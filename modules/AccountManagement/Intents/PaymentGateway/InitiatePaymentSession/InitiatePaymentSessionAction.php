<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\InitiatePaymentSession;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentGatewayOrder;
use Modules\UserManagement\Models\User;
use Modules\StudentManagement\Models\Student;

class InitiatePaymentSessionAction
{
    use AsAction;

    public function handle(array $dto, array $actionData): array
    {
        $merchantId   = config('services.cybersource.merchant_id');
        $keyId        = config('services.cybersource.key_id');
        $sharedSecret = config('services.cybersource.shared_secret');
        $env          = config('services.cybersource.env', 'test');
        $currency     = config('services.cybersource.currency', 'USD');

        // Fail loudly rather than silently charging in the wrong currency.
        // A TEST-environment log this session showed a real transaction going
        // out tagged 'USD' (the fallback above) for an LKR-sized amount — this
        // merchant's live MID is LKR (per HNB), so an unset CYBERSOURCE_CURRENCY
        // in production must never silently fall through to 'USD'.
        if ($env === 'production' && !config('services.cybersource.currency_explicit')) {
            throw new \Exception(
                'CYBERSOURCE_CURRENCY is not set in production. Set it explicitly '
                . '(expected LKR for this merchant) before any live payment session can be created.'
            );
        }

        $apiHost = $env === 'production'
            ? 'https://api.cybersource.com'
            : 'https://apitest.cybersource.com';

        // 1. Get firstName and lastName from logged-in user's full_name column (user table)
        $parentUser = User::find($actionData['user_id']);
        $userFullName = trim($parentUser?->full_name ?? $parentUser?->name ?? $parentUser?->username ?? 'Parent User');
        $nameParts    = explode(' ', $userFullName, 2);
        $billFirstName = $nameParts[0] ?? 'Parent';
        $billLastName  = $nameParts[1] ?? $billFirstName;

        // 2. Get email and address1 from selected student (student table)
        //
        // NOTE: uses filled() (not ??) to pick the first candidate — DB columns here
        // commonly default to '' rather than NULL, and ?? only falls back on NULL, so
        // an empty-string column would silently pass through as "" instead of trying
        // the next candidate. That previously sent CyberSource an empty
        // orderInformation.billTo.address1, which the widget rejects at submit time
        // with a MISSING_FIELD decline (INVALID_REQUEST) — see git history.
        $student     = Student::find($dto['student_id']);
        $billEmail   = collect([
            $student?->email,
            $student?->student_email,
            $student?->guardian_email,
            $student?->father_email,
            $student?->mother_email,
            $parentUser?->email,
        ])->first(fn ($v) => filled($v)) ?? 'payment@nexiscollege.lk';
        $billAddress = collect([
            $student?->full_address,
            $student?->student_address,
        ])->first(fn ($v) => filled($v)) ?? 'Nexis College';

        // ── Build Unified Checkout (UC) Session Payload ──────────────────────────────────────
        //
        // Endpoint: POST /uc/v1/sessions
        //
        // new Flex(captureContext) works identically with Unified Checkout capture
        // contexts. The UC session embeds consumerAuthentication (3DS) data inside
        // the token produced by microform.createToken(), so CyberSource handles 3DS
        // automatically at payment authorization — no separate Payer Auth call needed.
        //
        // The capture context JWT contains a clientLibrary URL pointing to the
        // UC-compatible version of the Flex SDK. We extract and return it so the
        // frontend always loads the correct SDK for this merchant configuration.
        //
        $appDomain = rtrim(config('app.url'), '/');

        $sessionPayload = [
            'targetOrigins'       => [$appDomain],
            'allowedCardNetworks' => ['VISA', 'MASTERCARD', 'AMEX'],

            // Google Pay is now enrolled/enabled for this merchant in Business
            // Center (was not, when this comment last said otherwise — see git
            // history for the prior "not requested" version).
            //
            // CLICKTOPAY re-added here (was moved OUT of this array into
            // paymentConfigurations-only in an earlier pass — that was likely the
            // actual mistake, not a fix): allowedPaymentTypes is what makes
            // CyberSource actually OFFER a payment type to the shopper;
            // paymentConfigurations.CLICKTOPAY only supplies settings for a type
            // that's already allowed. The live sandbox test that flagged the
            // GOOGLEPAY.allowedCardNetworks error did NOT flag
            // paymentConfigurations.CLICKTOPAY as invalid even with 'CLICKTOPAY'
            // absent from this array — so CyberSource's schema tolerates the
            // combination, but that's not the same as the widget actually
            // rendering the button. If Click to Pay still doesn't appear with
            // both present, the next thing to check is Business Center
            // enrollment/registration (see the doc this session is working from).
            'allowedPaymentTypes' => ['PANENTRY', 'GOOGLEPAY', 'CLICKTOPAY'],

            // paymentConfigurations is the documented CyberSource UC shape for
            // per-method options (NOT allowedPaymentTypes — an earlier version of
            // this file incorrectly guessed 'CLICKTOPAY' as an allowedPaymentTypes
            // entry).
            //
            // GOOGLEPAY.allowedAuthMethods: UNCONFIRMED against the actual HNB/
            // Business Center Google Pay configuration — both PAN_ONLY and
            // CRYPTOGRAM_3DS are requested here as the safe default (Google Pay
            // itself picks whichever the device/card supports), but if the
            // sandbox rejects one of these or Google Pay never renders in the
            // widget, check Business Center's Google Pay auth-method setting and
            // narrow this list to match.
            //
            // NOTE: allowedCardNetworks is NOT a valid key under
            // paymentConfigurations.GOOGLEPAY — a live sandbox call confirmed
            // CyberSource rejects it outright with UNIFIEDPAYMENTS_VALIDATION_FIELDS
            // / ADDITIONAL_PROPERTIES ("is not defined in the schema and the schema
            // does not allow additional properties"). Card networks for Google Pay
            // are governed by the top-level allowedCardNetworks above, not a
            // per-method override — do not re-add this key.
            //
            // CLICKTOPAY.autoCheckEnrollment:false means we don't ask CyberSource
            // to silently check enrollment on load; the widget only offers Click
            // to Pay if/when the user opts in.
            'paymentConfigurations' => [
                'GOOGLEPAY' => [
                    'allowedAuthMethods' => ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                ],
                'CLICKTOPAY' => ['autoCheckEnrollment' => false],
            ],

            'country' => 'LK',
            'locale'  => 'en_US',
            'data'    => [
                // Binds the resulting CyberSource transaction to our own order —
                // CompletePaymentAction looks this up server-to-server to confirm the
                // transaction it's about to record actually belongs to the order being
                // completed, not a different (e.g. cheaper) order's token.
                'clientReferenceInformation' => [
                    'code' => $actionData['order_reference'],
                ],
                'orderInformation' => [
                    'amountDetails' => [
                        // Fee-inclusive total — CyberSource authorizes/charges this
                        // amount, not the bare invoice amount. See
                        // InitiatePaymentSessionIntent for the fee calculation.
                        'totalAmount' => number_format((float) $actionData['total_charged_amount'], 2, '.', ''),
                        'currency'    => $currency,
                    ],
                    // Pre-populate billTo so the widget does not prompt the parent for
                    // billing address details.
                    // - firstName / lastName: derived from logged-in user full_name
                    // - email / address1: derived from selected student record
                    // - locality / postalCode / country: sample default values
                    'billTo'        => [
                        'firstName'  => $billFirstName,
                        'lastName'   => $billLastName,
                        'email'      => $billEmail,
                        'address1'   => $billAddress,
                        'locality'   => 'Colombo',
                        'postalCode' => '00100',
                        'country'    => 'LK',
                    ],
                ],
            ],

            // completeMandate: tells the UC widget to perform the full transaction inside
            // the widget. checkout.mount() resolves with a completed payment JWT (not a
            // transient token). consumerAuthentication is an ENUM (NONE | 3DS | PASSKEY),
            // not a boolean — CyberSource sandbox rejected `true` with
            // UNIFIEDPAYMENTS_VALIDATION_FIELDS (ENUM + TYPE errors). '3DS' explicitly
            // requests Payer Authentication.
            //
            // type: 'CAPTURE' (was 'AUTH') — CyberSource now authorizes AND captures funds
            // in one step, instead of leaving the transaction authorization-only pending a
            // separate manual capture in the CyberSource Business Center. This does NOT
            // change the internal admin_status approval gate below (that's a separate
            // accounting step on the ReceiptVoucher, not a CyberSource capture call) — see
            // CompletePaymentAction::recordSuccessfulPayment for the matching wording fix.
            //
            // NOTE: 'SALE' is NOT a valid value here — a live sandbox call confirmed
            // CyberSource's actual completeMandate.type enum is [AUTH, CAPTURE,
            // PREFER_AUTH] (400 UNIFIEDPAYMENTS_VALIDATION_FIELDS / ENUM otherwise).
            // 'CAPTURE' is the correct value for auth+capture in one step.
            'completeMandate' => ['type' => 'CAPTURE', 'consumerAuthentication' => '3DS'],

            // NOTE: Field visibility (email, phone, billing/shipping address, review step)
            // is controlled via the CyberSource Business Center portal — not this payload.
            // Path: Payment Configuration → Unified Checkout → Customer data and payment flow.
        ];

        // ── HMAC-SHA256 Signing ────────────────────────────────────────
        // CRITICAL: The request-target in the signature MUST match the actual
        // endpoint path exactly. Using the wrong path causes 401 Unauthorized.
        $date          = gmdate('D, d M Y H:i:s') . ' GMT';
        $requestId     = $actionData['order_reference'];  // Idempotency key
        $hostName      = parse_url($apiHost, PHP_URL_HOST);
        $body          = json_encode($sessionPayload, JSON_UNESCAPED_SLASHES);
        $digest        = 'SHA-256=' . base64_encode(hash('sha256', $body, true));
        $requestTarget = 'post /uc/v1/sessions';

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

        $secureHeaders = [
            'Host'            => $hostName,
            'Date'            => $date,
            'Digest'          => $digest,
            'Signature'       => $signatureHeader,
            'v-c-merchant-id' => $merchantId,
            'v-c-request-id'  => $requestId,
            'Content-Type'    => 'application/json',
        ];

        // ── Call CyberSource Unified Checkout Session ───────────────────────────
        Log::info('CyberSource Unified Checkout Session: calling /uc/v1/sessions', [
            'host'          => $hostName,
            'targetOrigins' => $sessionPayload['targetOrigins'],
            'networks'      => $sessionPayload['allowedCardNetworks'],
            'completeMandate'        => $sessionPayload['completeMandate'], 
            'merchantId'    => $merchantId,
        ]);

        try {
            // throw: false — prevents retry() from throwing RequestException internally.
            // Without this, the retry mechanism calls $response->throw() before returning,
            // which means $response->failed() is never reached and the FULL error body
            // is never logged. With throw:false, we handle the error ourselves below.
            $response = Http::timeout(10)
                ->retry(2, 500, function ($exception) {
                    return $exception instanceof \Illuminate\Http\Client\ConnectionException;
                }, throw: false)
                ->withHeaders($secureHeaders)
                ->withBody($body, 'application/json')
                ->post("{$apiHost}/uc/v1/sessions");

            if ($response->failed()) {
                Log::error('CyberSource Unified Checkout Session API Error', [
                    'http_status'  => $response->status(),
                    'full_body'    => $response->body(),
                    'payload_sent' => array_merge($sessionPayload, ['targetOrigins' => ['[redacted]']]),
                ]);
                throw new \Exception('CyberSource Unified Checkout Session error ' . $response->status() . ': ' . $response->body());
            }

            // ── Parse capture context ──────────────────────────────────────
            $contentType  = $response->header('Content-Type') ?? '';
            $responseBody = trim($response->body());

            if (strpos($contentType, 'application/json') !== false || strpos($contentType, 'text/json') !== false) {
                $decoded        = $response->json();
                $captureContext = $decoded['captureContext'] ?? $decoded['capture_context'] ?? $responseBody;
            } else {
                $captureContext = $responseBody;
            }

            // ── Check 1: Non-empty ─────────────────────────────────────────
            // Guard before logging or passing to frontend. An HTTP 200 with an
            // empty body means the response was parsed incorrectly (wrong key,
            // wrong Content-Type branch, or CyberSource sent no body).
            if (empty($captureContext)) {
                Log::error('Unified Checkout Session: capture context is empty after HTTP 200', [
                    'content_type' => $contentType,
                    'body_length'  => strlen($responseBody),
                    'raw_preview'  => substr($responseBody, 0, 120),
                ]);
                throw new \Exception('CyberSource Unified Checkout Session returned an empty capture context (HTTP 200 but empty body)');
            }

            // ── Phase 1: Backend verification log ─────────────────────────
            // Logs status, Content-Type, first 80 chars of context (never full JWT),
            // and whether the response is a 3-part JWT. Share this log output for diagnosis.
            Log::info('Unified Checkout Session Raw Response', [
                'http_status'        => $response->status(),
                'content_type'       => $contentType,
                'context_non_empty'  => true,            // reached = non-empty confirmed
                'is_jwt'             => substr_count($captureContext, '.') === 2,
                'context_length'     => strlen($captureContext),
                'context_preview_80' => substr($captureContext, 0, 80),
            ]);

            // ── Extract clientLibrary URL from the UC capture context JWT ───────────
            // The UC capture context is a JWT. Its payload section (the middle of
            // the three dot-separated parts) contains ctx[0].data.clientLibrary,
            // which points to the UC-compatible version of the Flex SDK. Using the
            // correct URL from the JWT ensures the frontend always loads the right
            // SDK for this merchant's UC configuration.
            $clientLibraryUrl = null;
            $jwtParts = explode('.', $captureContext);
            if (count($jwtParts) === 3) {
                $jwtPayload = json_decode(
                    base64_decode(
                        str_pad(strtr($jwtParts[1], '-_', '+/'), strlen($jwtParts[1]) % 4, '=')
                    ),
                    true
                );
                $clientLibraryUrl = $jwtPayload['ctx'][0]['data']['clientLibrary'] ?? null;

                Log::info('Unified Checkout Session: clientLibrary extracted from JWT', [
                    'client_library_url' => $clientLibraryUrl ?? 'NOT_FOUND_IN_JWT',
                ]);
            }

            // Fallback if JWT decoding fails or key is absent
            if (empty($clientLibraryUrl)) {
                $clientLibraryUrl = $env === 'production'
                    ? 'https://flex.cybersource.com/microform/bundle/v2/flex-microform.min.js'
                    : 'https://testflex.cybersource.com/microform/bundle/v2/flex-microform.min.js';

                Log::warning('Unified Checkout Session: clientLibrary not found in JWT, using fallback', [
                    'fallback_url' => $clientLibraryUrl,
                ]);
            }

            // ── Persist Order Record ───────────────────────────────────
            // Created BEFORE returning to prevent double-charges if the client
            // retries the initiation request.
            PaymentGatewayOrder::create([
                'order_reference'        => $actionData['order_reference'],
                'user_id'                => $actionData['user_id'],
                'student_id'             => $dto['student_id'],
                'invoice_type'           => $dto['invoice_type'],
                'invoice_id'             => $dto['invoice_id'],
                'amount'                 => $dto['amount'],
                'currency'               => $currency,
                'service_fee_percentage' => $actionData['service_fee_percentage'],
                'service_fee_amount'     => $actionData['service_fee_amount'],
                'total_charged_amount'   => $actionData['total_charged_amount'],
                'status'                 => 'pending',
                'admin_status'           => 'pending_review',
                'expires_at'             => now()->addMinutes(15),
            ]);

            return [
                'capture_context'          => $captureContext,
                'client_library_url'       => $clientLibraryUrl,
                'client_library_integrity' => '',  // Not provided by UC API; SRI skipped
                'order_reference'          => $actionData['order_reference'],
                'amount'                   => (float) $dto['amount'],
                'currency'                 => $currency,
                'service_fee_amount'       => (float) $actionData['service_fee_amount'],
                'total_charged_amount'     => (float) $actionData['total_charged_amount'],
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('HNB CyberSource UC Session API Unreachable/Timeout: ' . $e->getMessage());
            throw new \Exception('GATEWAY_TIMEOUT');

        } catch (\Throwable $e) {
            // Catch ALL exceptions (including \Exception from $response->failed() path above).
            // Without this, any uncaught exception kills PHP-FPM mid-response, causing
            // Cloudflare to see an incomplete connection and return 502 Bad Gateway.
            Log::error('HNB CyberSource UC Session unexpected error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
            ]);
            throw $e;   // Rethrow so the Intent layer converts it to a proper HTTP response
        }
    }
}