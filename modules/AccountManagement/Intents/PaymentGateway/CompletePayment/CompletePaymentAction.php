<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\CompletePayment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentGatewayOrder;
use Modules\AccountManagement\Services\CyberSourceJwtVerifier;

class CompletePaymentAction
{
    use AsAction;

    /**
     * lorisleiva/laravel-actions resolves constructor dependencies via the
     * Laravel service container — no AppServiceProvider binding needed.
     */
    public function __construct(
        private readonly CyberSourceJwtVerifier $verifier,
    ) {}

    public function handle(array $dto, array $actionData): array
    {
        $order = $actionData['order'];

        // 1. Store the token immediately (before any gateway call).
        //    transient_token_hash is the SHA-256 digest of the token.
        //    It has a unique DB constraint — the database will reject a second
        //    order that tries to store the same token hash (Layer 2 of duplicate prevention).
        $order->transient_token      = $dto['transient_token'];
        $order->transient_token_hash = hash('sha256', $dto['transient_token']);
        $order->save();

        // 2. Cryptographically verify the JWT returned by checkout.mount().
        //
        //    CyberSourceJwtVerifier:
        //      - Extracts kid from the JWT header
        //      - Fetches and caches the RS256 public key from CyberSource JWKS
        //      - Verifies the RS256 signature (primary security check)
        //      - Validates exp and iat claims
        //      - Returns the verified payload — throws on any failure
        //
        //    iss is NOT validated: CyberSource UC result JWTs do not populate this
        //    claim and no expected value is documented. RS256 signature is the
        //    primary trust mechanism.
        //
        //    Two possible verified token types:
        //
        //    A) UC Completed Payment JWT (completeMandate / autoProcessing=true)
        //       Keys: metadata, details, id, message, outcome, status
        //       Payment already authorized inside the UC widget — skip /pts/v2/payments.
        //
        //    B) Flex / UC Transient Card Token (tokenization-only path)
        //       Keys: flx, content, iat, exp, ...
        //       Card tokenized but not charged — must call /pts/v2/payments.
        try {
            $jwtPayload = $this->verifier->verify($dto['transient_token']);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Could not reach CyberSource to fetch the JWKS public key — this is
            // OUR connectivity failing, not evidence the token is invalid. The
            // token itself may well represent a real authorized payment we simply
            // couldn't verify. Rethrow as-is so it's handled by the same
            // gateway_timeout path as authorizeCyberSourcePayment()'s timeout,
            // NOT misclassified as JWT_VERIFICATION_FAILED (which implies tampering).
            Log::error('CompletePayment: could not reach CyberSource to verify JWT — outcome unknown', [
                'order_reference' => $order->order_reference,
                'reason'          => $e->getMessage(),
                'user_id'         => $order->user_id,
            ]);
            throw $e;
        } catch (\Exception $e) {
            // Signature invalid, expired, malformed, or unknown kid — the token
            // itself is untrustworthy. Do NOT create a ReceiptVoucher.
            Log::error('CompletePayment: JWT verification FAILED — rejecting token', [
                'order_reference' => $order->order_reference,
                'reason'          => $e->getMessage(),
                'user_id'         => $order->user_id,
            ]);

            // NOTE: Do not write $order here — this runs inside the caller's
            // DB::transaction(), and throwing below rolls it back, discarding
            // any write made in this method. The decision/reference are carried
            // in the exception instead, and applied by asController() afterwards.
            throw new PaymentFailureException('PAYMENT_JWT_INVALID', 'JWT_VERIFICATION_FAILED');
        }

        $ucStatus   = $jwtPayload['status'] ?? null;
        $ucId       = $jwtPayload['id']     ?? null;
        $hasFlx     = isset($jwtPayload['flx']);
        $hasContent = isset($jwtPayload['content']);

        $isUcResult = !$hasFlx && !$hasContent
                   && isset($jwtPayload['status'])
                   && isset($jwtPayload['outcome']);

        Log::info('CompletePayment: UC token JWT verified and decoded', [
            'order_reference' => $order->order_reference,
            'jwt_all_keys'    => array_keys($jwtPayload),
            // UC completed result fields:
            'status'          => $ucStatus,
            'id'              => $ucId,
            'reason'          => $jwtPayload['reason']  ?? null,
            'outcome'         => $jwtPayload['outcome'] ?? null,
            // CyberSource error details — populated when status is not AUTHORIZED:
            'details'         => $jwtPayload['details'] ?? null,
            'message'         => $jwtPayload['message'] ?? null,
            // Flex transient token markers:
            'flx'             => $hasFlx     ? '[present]' : null,
            'content'         => $hasContent ? '[present]' : null,
            // Token path decision:
            'path'            => $isUcResult
                                    ? ($ucStatus === 'AUTHORIZED' ? 'UC_COMPLETED_RESULT' : 'UC_FAILED_RESULT')
                                    : 'TRANSIENT_TOKEN',
        ]);


        // 3. Branch on JWT type and payment outcome (uses $isUcResult computed above)
        //
        // UC completed result: produced by completeMandate + autoProcessing.
        //   → has 'status' and 'outcome' keys, no 'flx' or 'content'
        // Flex transient token: produced by old Microform flow.
        //   → has 'flx' and/or 'content' keys

        if ($isUcResult && $ucStatus === 'AUTHORIZED' && !empty($ucId)) {
            //
            // ── Path A: UC completed payment — success ────────────────────────────
            // The Unified Checkout widget already performed AUTH (and 3DS).
            // The JWT payload carries status=AUTHORIZED and the CyberSource
            // transaction ID. No further /pts/v2/payments call is needed.
            //
            Log::info('CompletePayment: UC completed result — AUTHORIZED', [
                'order_reference'   => $order->order_reference,
                'cybersource_tx_id' => $ucId,
            ]);

            return $this->handleUcCompletedPayment($order, $ucId, $jwtPayload);
        }

        if ($isUcResult && $ucStatus !== 'AUTHORIZED') {
            //
            // ── Path A-FAIL: UC completed result — payment declined inside widget ─
            // The widget ran the full AUTH flow but the bank or CyberSource declined.
            // The result JWT has status/outcome keys but status is not AUTHORIZED
            // (e.g. INVALID_REQUEST, DECLINED, ERROR, AUTHENTICATION_FAILED).
            //
            // IMPORTANT: Do NOT fall through to /pts/v2/payments.
            // That endpoint requires a transient card token. Sending a UC result JWT
            // always fails with MISSING_FIELD: card.number — exactly what we saw.
            //
            Log::warning('CompletePayment: UC result — payment declined inside widget, not calling /pts/v2/payments', [
                'order_reference' => $order->order_reference,
                'uc_status'       => $ucStatus,
                'uc_outcome'      => $jwtPayload['outcome'] ?? null,
                'uc_reason'       => $jwtPayload['reason']  ?? null,
                'cybersource_id'  => $ucId,
            ]);

            // NOTE: see comment above the JWT_VERIFICATION_FAILED throw — no write
            // here, this still runs inside the caller's transaction.
            throw new PaymentFailureException('PAYMENT_DECLINED', $ucStatus, $ucId);
        }

        // ── Path B: Raw transient token ───────────────────────────────────────
        // No completeMandate / autoProcessing — card tokenized but not charged.
        // Must call /pts/v2/payments to authorize.
        $user      = $actionData['user'];
        $nameParts = explode(' ', trim($user->name ?? 'Parent User'), 2);

        // NOTE: administrativeArea is required only for US, CA, CN, BR.
        // For Sri Lanka (LK) it is optional — an unrecognised value causes HTTP 502.
        $billTo = [
            'firstName'  => $nameParts[0] ?? 'Parent',
            'lastName'   => $nameParts[1] ?? $nameParts[0] ?? 'User',
            'email'      => $user->email ?? 'parent@school.lk',
            'address1'   => 'Nexis College Payment',
            'locality'   => 'Colombo',
            'postalCode' => '00100',
            'country'    => 'LK',
        ];

        $cyberResult = $this->authorizeCyberSourcePayment(
            $dto['transient_token'],
            (float) $order->total_charged_amount,
            $order->currency,
            $order->order_reference,
            $billTo
        );

        $authorizedDecisions = ['AUTHORIZED', 'AUTHORIZED_PENDING_REVIEW'];

        if (!in_array($cyberResult['decision'], $authorizedDecisions)) {
            Log::warning('Payment declined by CyberSource', [
                'order_reference'  => $order->order_reference,
                'decision'         => $cyberResult['decision'],
                'reason_code'      => $cyberResult['reason_code'] ?? null,
                'error_message'    => $cyberResult['error_message'] ?? null,
                'full_response'    => $cyberResult['raw_response'] ?? null,
                'user_id'          => $order->user_id,
            ]);

            // NOTE: see comment above the JWT_VERIFICATION_FAILED throw — no write
            // here, this still runs inside the caller's transaction.
            throw new PaymentFailureException('PAYMENT_DECLINED', $cyberResult['decision'], $cyberResult['reference'] ?? null);
        }

        return $this->recordSuccessfulPayment($order, $cyberResult['reference'], $cyberResult['decision']);
    }

    /**
     * Handle a UC Completed Payment JWT (autoProcessing=true / completeMandate path).
     *
     * The UC widget has already authorized the payment. The JWT itself only proves
     * *a* payment was authorized by CyberSource — it does not prove it was authorized
     * for *this* order (a validly-signed JWT from a legitimately completed cheap order
     * could otherwise be replayed against a different, more expensive order_reference
     * belonging to the same user). Before recording success we confirm the order
     * binding using the JWT's own `details` claim (clientReferenceInformation.code +
     * authorized amount/currency) — this claim is inside the RS256-signed payload
     * already verified by CyberSourceJwtVerifier, so it's as trustworthy as a live
     * API call would be, without the live call.
     *
     * NOTE: an earlier version of this check called CyberSource's Transaction Search
     * API (GET /tss/v2/transactions/{id}) instead. That endpoint is backed by an
     * asynchronous search index and returned 404 for transactions looked up
     * immediately after authorization (confirmed in production) — it is not suitable
     * for a synchronous check right after payment. The JWT's `details` claim has no
     * such indexing delay since it's returned directly by checkout.mount().
     */
    private function handleUcCompletedPayment(PaymentGatewayOrder $order, string $cybersourceTransactionId, array $jwtPayload): array
    {
        $binding = $this->verifyOrderBindingFromJwtDetails($jwtPayload, $order);

        if (!$binding['ok']) {
            Log::error('CompletePayment: order binding check FAILED — refusing to record payment', [
                'order_reference'   => $order->order_reference,
                'cybersource_tx_id' => $cybersourceTransactionId,
                'reason'            => $binding['reason'],
            ]);

            // NOTE: see comment above the JWT_VERIFICATION_FAILED throw — no write
            // here, this still runs inside the caller's transaction.
            throw new PaymentFailureException('PAYMENT_ORDER_BINDING_MISMATCH', 'ORDER_BINDING_MISMATCH', $cybersourceTransactionId);
        }

        return $this->recordSuccessfulPayment($order, $cybersourceTransactionId, 'AUTHORIZED');
    }

    /**
     * Confirms clientReferenceInformation.code (set to order_reference at session
     * creation — see InitiatePaymentSessionAction) and the authorized amount/currency
     * inside the JWT's `details` claim match this order.
     *
     * @return array{ok: bool, reason: ?string}
     */
    private function verifyOrderBindingFromJwtDetails(array $jwtPayload, PaymentGatewayOrder $order): array
    {
        // $jwtPayload is only cast to array at the top level (firebase/php-jwt
        // decodes to nested stdClass) — normalise `details` to a plain array.
        $rawDetails = $jwtPayload['details'] ?? null;
        $details    = $rawDetails !== null
            ? json_decode(json_encode($rawDetails), true)
            : null;

        $actualReference = $details['clientReferenceInformation']['code'] ?? null;
        $actualAmount    = $details['orderInformation']['amountDetails']['authorizedAmount'] ?? null;
        $actualCurrency  = $details['orderInformation']['amountDetails']['currency'] ?? null;

        // Compare against total_charged_amount (amount + service fee), NOT the bare
        // invoice amount — CyberSource authorized the fee-inclusive total (see
        // InitiatePaymentSessionAction, which sends total_charged_amount as
        // orderInformation.amountDetails.totalAmount). Comparing against `amount`
        // alone would make every payment fail this check once a fee is applied.
        $expectedAmount = (float) $order->total_charged_amount;

        Log::info('CompletePayment: order binding check (from JWT details claim)', [
            'order_reference'   => $order->order_reference,
            'actual_reference'  => $actualReference,
            'actual_amount'     => $actualAmount,
            'actual_currency'   => $actualCurrency,
            'expected_amount'   => (string) $expectedAmount,
            'expected_currency' => $order->currency,
        ]);

        if ($actualReference === null || $actualReference !== $order->order_reference) {
            return ['ok' => false, 'reason' => 'ORDER_REFERENCE_MISMATCH'];
        }

        if ($actualAmount === null || abs((float) $actualAmount - $expectedAmount) > 0.01) {
            return ['ok' => false, 'reason' => 'AMOUNT_MISMATCH'];
        }

        if ($actualCurrency === null || $actualCurrency !== $order->currency) {
            return ['ok' => false, 'reason' => 'CURRENCY_MISMATCH'];
        }

        return ['ok' => true, 'reason' => null];
    }

    /**
     * Shared success workflow: mark the order completed, log. Used by both the
     * UC completed result path and the transient token path.
     *
     * Deliberately writes ONLY to payment_gateway_orders — no ReceiptVoucher or
     * any other Account Management table is touched here. Reconciling a
     * completed order into the school's invoice/accounting records (creating a
     * ReceiptVoucher, updating an invoice balance, etc.) is intentionally a
     * separate process outside this payment-gateway module, not something this
     * code does automatically.
     */
    private function recordSuccessfulPayment(PaymentGatewayOrder $order, string $reference, string $decision): array
    {
        $order->status                = 'completed';
        $order->cybersource_reference = $reference;
        $order->cybersource_decision  = $decision;
        $order->transient_token       = null; // No longer needed once the order is terminal
        $order->save();

        Log::info('Payment captured — payment_gateway_orders updated only', [
            'order_reference'      => $order->order_reference,
            'cybersource_ref'      => $reference,
            'cybersource_decision' => $decision,
            'amount'               => $order->amount,
            'invoice_type'         => $order->invoice_type,
            'invoice_id'           => $order->invoice_id,
            'student_id'           => $order->student_id,
            'user_id'              => $order->user_id,
        ]);

        return [
            'order_reference'      => $order->order_reference,
            'status'               => 'completed',
            'amount'               => (float) $order->amount,
            'currency'             => $order->currency,
            'service_fee_amount'   => (float) $order->service_fee_amount,
            'total_charged_amount' => (float) $order->total_charged_amount,
            'invoice_type'         => $order->invoice_type,
            'invoice_id'           => $order->invoice_id,
            'receipt_voucher_id'   => null,
            'message'              => 'Payment captured successfully. Your invoice will be updated once the finance team confirms this payment.',
        ];
    }

    /**
     * Call CyberSource /pts/v2/payments to authorize the UC transient token.
     *
     * The transient token comes from the Unified Checkout (UC) session created via
     * /uc/v1/sessions with consumerAuthentication:true. The UC session embeds the
     * 3DS payer authentication result inside the token, so CyberSource automatically
     * performs 3DS verification during authorization — no separate Payer Auth API call needed.
     *
     * Returns: ['decision' => 'AUTHORIZED'|'AUTHORIZED_PENDING_REVIEW'|'DECLINED'|..., ...]
     */
    private function authorizeCyberSourcePayment(string $transientToken, float $amount, string $currency, string $orderReference, array $billTo): array
    {
        $merchantId   = config('services.cybersource.merchant_id');
        $keyId        = config('services.cybersource.key_id');
        $sharedSecret = config('services.cybersource.shared_secret');
        $env          = config('services.cybersource.env', 'test');

        $apiHost = $env === 'production'
            ? 'https://api.cybersource.com'
            : 'https://apitest.cybersource.com';

        // ── Build Payment Payload ─────────────────────────────────────
        //
        // capture: true in both environments — HNB's live MID requirement is
        // Transaction type = Sale (auto-capture, no manual settlement step),
        // matching completeMandate.type = 'CAPTURE' already used in the primary
        // Unified Checkout path (InitiatePaymentSessionAction.php). This method
        // is the fallback path (raw transient token, not a completed UC result —
        // see the isUcResult branch above), but it must still follow the same
        // Sale policy: no authorize-only capture=false, ever, in production.
        $capture = true;

        $paymentPayload = [
            'tokenInformation' => [
                'transientTokenJwt' => $transientToken,
            ],
            'orderInformation' => [
                'amountDetails' => [
                    'totalAmount' => number_format($amount, 2, '.', ''),
                    // Use the currency recorded on the order at session-creation time
                    // (CYBERSOURCE_CURRENCY at that point), not a hardcoded literal —
                    // keeps authorization consistent with what the UC session declared.
                    'currency'    => $currency,
                ],
                // CyberSource requires billTo for authorization
                'billTo' => $billTo,
            ],
            'clientReferenceInformation' => [
                'code' => $orderReference,
            ],
            'processingInformation' => [
                'capture' => $capture,
            ],
        ];

        // ── HMAC-SHA256 Signing ───────────────────────────────────────
        $requestTarget = 'post /pts/v2/payments';
        $date          = gmdate('D, d M Y H:i:s') . ' GMT';
        $requestId     = Str::uuid()->toString();
        $body          = json_encode($paymentPayload, JSON_UNESCAPED_SLASHES);
        $digest        = 'SHA-256=' . base64_encode(hash('sha256', $body, true));
        $hostName      = parse_url($apiHost, PHP_URL_HOST);

        $signatureString = implode("\n", [
            "host: {$hostName}",
            "date: {$date}",
            "request-target: {$requestTarget}",
            "digest: {$digest}",
            "v-c-merchant-id: {$merchantId}",
        ]);

        $signature = base64_encode(hash_hmac('sha256', $signatureString, base64_decode($sharedSecret), true));

        $signatureHeader = implode(', ', [
            "keyid=\"{$keyId}\"",
            'algorithm="HmacSHA256"',
            'headers="host date request-target digest v-c-merchant-id"',
            "signature=\"{$signature}\"",
        ]);

        // ── HTTP Call ─────────────────────────────────────────────────
        Log::info('CyberSource Payment: Sending authorization request', [
            'order_reference' => $orderReference,
            'full_payload'    => array_merge($paymentPayload, [
                'tokenInformation' => ['transientTokenJwt' => substr($transientToken, 0, 30) . '...[masked]'],
            ]),
            'capture'         => $capture,
            'env'             => $env,
            'api_host'        => $apiHost,
        ]);
        try {
            // IMPORTANT: No ->retry() here — payment authorization is NOT idempotent.
            // Retrying can cause a double charge if the first request succeeded but
            // the response was slow. Use a generous single timeout instead.
            $response = Http::timeout(30)
                ->withHeaders([
                    'Host'            => $hostName,
                    'Date'            => $date,
                    'Digest'          => $digest,
                    'Signature'       => $signatureHeader,
                    'v-c-merchant-id' => $merchantId,
                    'v-c-request-id'  => $requestId,
                    'Content-Type'    => 'application/json',
                ])
                ->withBody($body, 'application/json')
                ->post("{$apiHost}/pts/v2/payments");

            $statusCode   = $response->status();
            $responseData = $response->json();

            Log::info('CyberSource Payment API Response', [
                'http_status'    => $statusCode,
                'cs_status'      => $responseData['status'] ?? 'UNKNOWN',
                'cs_id'          => $responseData['id'] ?? null,
                'full_response'  => $responseData,  // Full response for debugging decline reasons
            ]);

            // 201 = Successfully processed (AUTHORIZED, AUTHORIZED_PENDING_REVIEW, or DECLINED)
            if ($statusCode === 201) {
                return [
                    'decision'      => $responseData['status'] ?? 'UNKNOWN',
                    'reference'     => $responseData['id'] ?? null,
                    'reason_code'   => $responseData['errorInformation']['reason'] ?? null,
                    'error_message' => $responseData['errorInformation']['message'] ?? null,
                    'raw_response'  => $responseData,   // Passed through for decline logging
                ];
            }

            // Any other status — treat as declined
            Log::error('CyberSource Payment API unexpected status', [
                'http_status' => $statusCode,
                'body'        => $response->body(),
            ]);

            return [
                'decision'      => 'DECLINED',
                'reference'     => $responseData['id'] ?? null,
                'reason_code'   => $responseData['reason'] ?? 'UNKNOWN',
                'error_message' => $responseData['message'] ?? 'Unexpected API response',
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Do NOT mark as declined — charge status with the bank is UNKNOWN.
            // The order will be marked 'gateway_timeout' by the intent handler (outside
            // the rolled-back transaction) so admin can check the CyberSource dashboard.
            Log::error('CyberSource Payment API timeout/unreachable — charge status unknown', [
                'order_reference' => $orderReference,
                'error'           => $e->getMessage(),
            ]);
            throw new \Illuminate\Http\Client\ConnectionException('GATEWAY_TIMEOUT');
        }
    }
}
