<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\CompletePayment;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentGatewayOrder;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CompletePaymentIntent
{
    use AsAction;

    public function handle(Request $request): array
    {
        $dto  = CompletePaymentUserDTO::validate($request->all());
        $user = $request->user();

        Log::info('CompletePayment: Starting', [
            'order_reference' => $dto['order_reference'],
            'user_id'         => $user?->id,
        ]);

        // Entire lookup + completion wrapped in a transaction with pessimistic locking.
        // lockForUpdate() blocks concurrent requests until this transaction completes,
        // preventing double-payment race conditions.
        return DB::transaction(function () use ($dto, $user) {

            // ── Idempotency check (Layer 1 of 2) ─────────────────────────────────
            // If the same UC result JWT was already processed for a completed order,
            // return the existing result instead of a confusing 404.
            //
            // Scenario: app sends the token → backend succeeds → network drops before
            // response → app retries with the same token. Without this check the second
            // request finds status != 'pending' and returns 404, leaving the app stuck.
            //
            // We hash the token here (before it is stored) because transient_token is
            // a TEXT column that cannot be queried efficiently. The hash column is
            // VARCHAR(64) with a unique index — O(1) lookup.
            $tokenHash = hash('sha256', $dto['transient_token']);

            $alreadyCompleted = PaymentGatewayOrder::where('transient_token_hash', $tokenHash)
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->first();

            if ($alreadyCompleted) {
                Log::info('CompletePayment: duplicate token — returning existing result (idempotent)', [
                    'order_reference'    => $alreadyCompleted->order_reference,
                    'cybersource_ref'    => $alreadyCompleted->cybersource_reference,
                    'receipt_voucher_id' => $alreadyCompleted->receipt_voucher_id,
                    'user_id'            => $user->id,
                ]);

                return [
                    'order_reference'      => $alreadyCompleted->order_reference,
                    'status'               => 'completed',
                    'amount'               => (float) $alreadyCompleted->amount,
                    'currency'             => $alreadyCompleted->currency,
                    'service_fee_amount'   => (float) $alreadyCompleted->service_fee_amount,
                    'total_charged_amount' => (float) $alreadyCompleted->total_charged_amount,
                    'invoice_type'         => $alreadyCompleted->invoice_type,
                    'invoice_id'           => $alreadyCompleted->invoice_id,
                    'receipt_voucher_id'   => $alreadyCompleted->receipt_voucher_id,
                    'message'              => 'Payment authorized successfully. It will be reviewed and confirmed by the finance team before your balance is updated.',
                ];
            }

            // ── Normal flow ───────────────────────────────────────────────────────
            $order = PaymentGatewayOrder::where('order_reference', $dto['order_reference'])
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->lockForUpdate()   // Pessimistic lock — blocks concurrent duplicate requests
                ->first();

            if (!$order) {
                Log::warning('CompletePayment: Order not found or not pending', [
                    'order_reference' => $dto['order_reference'],
                    'user_id'         => $user->id,
                ]);
                abort(404, 'Payment order not found or already completed.');
            }

            Log::info('CompletePayment: Order found', [
                'order_id' => $order->id,
                'amount'   => $order->amount,
                'expired'  => $order->isExpired(),
            ]);

            // Check expiry — prevents replay attacks with old transient tokens.
            // Don't write the 'expired' status here: this runs inside DB::transaction(),
            // and throwing below rolls the transaction back, which would silently
            // discard an update() made in this same closure. Instead, throw a bare
            // marker exception and let asController() apply the status update in its
            // own query afterwards, once this transaction has already rolled back
            // (same pattern as the ConnectionException/gateway_timeout handler below).
            if ($order->isExpired()) {
                throw new \Exception('PAYMENT_SESSION_EXPIRED');
            }

            // Complete the payment
            $actionData = ['order' => $order, 'user' => $user];
            return CompletePaymentAction::run($dto, $actionData);
        });
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            $resDTO = CompletePaymentResDTO::validate($result);

            return response()->json([
                'status'   => 'successful',
                'message'  => $result['message'],
                'data'     => $resDTO,
                'metadata' => null,
            ], 200);

        } catch (HttpException $e) {
            // Handle abort(404), abort(422) etc. — return proper HTTP status, not 500
            Log::warning('CompletePayment: HTTP error', [
                'status'  => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ]);
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
                'error'   => 'ORDER_ERROR',
            ], $e->getStatusCode());

        } catch (ConnectionException $e) {
            // CyberSource API timed out during payment authorization.
            // The DB transaction was already rolled back, so we update the order status
            // directly (outside any transaction) to 'gateway_timeout'.
            // Admin MUST check the CyberSource Business Centre dashboard to determine
            // whether the card was actually charged before taking any action.
            $orderRef = $request->input('order_reference');
            $user     = $request->user();
            if ($orderRef && $user) {
                PaymentGatewayOrder::where('order_reference', $orderRef)
                    ->where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->update([
                        'status'               => 'gateway_timeout',
                        'cybersource_decision' => 'GATEWAY_TIMEOUT',
                    ]);
            }
            Log::error('CompletePayment: Gateway timeout — card charge status UNKNOWN', [
                'order_reference' => $orderRef ?? 'unknown',
                'user_id'         => $user?->id,
            ]);
            return response()->json([
                'status'  => 'failed',
                'message' => 'The payment server took too long to respond. Please contact the finance office — do not retry this payment.',
                'error'   => 'GATEWAY_TIMEOUT',
            ], 504);

        } catch (PaymentFailureException $e) {
            // JWT invalid, card declined, or order-binding mismatch — detected inside
            // CompletePaymentAction, which runs inside the DB::transaction() above.
            // That transaction has already been rolled back by the time we're here
            // (any write CompletePaymentAction made was discarded), so apply the
            // status/decision/reference in a standalone query now, same pattern as
            // the ConnectionException and PAYMENT_SESSION_EXPIRED handlers.
            $orderRef = $request->input('order_reference');
            $user     = $request->user();
            if ($orderRef && $user) {
                PaymentGatewayOrder::where('order_reference', $orderRef)
                    ->where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->update(array_filter([
                        'status'                => 'failed',
                        'cybersource_decision'  => $e->cybersourceDecision,
                        'cybersource_reference' => $e->cybersourceReference,
                    ], fn ($value) => $value !== null));
            }

            Log::warning('CompletePayment: payment failure recorded', [
                'order_reference' => $orderRef ?? 'unknown',
                'user_id'         => $user?->id,
                'error_code'      => $e->getMessage(),
                'decision'        => $e->cybersourceDecision,
                'reference'       => $e->cybersourceReference,
            ]);

            $messages = [
                'PAYMENT_JWT_INVALID'             => 'Payment verification failed. Please try again.',
                'PAYMENT_DECLINED'                => 'Your payment was declined by the bank. Your account has not been charged.',
                'PAYMENT_ORDER_BINDING_MISMATCH'  => 'Payment verification failed. Please contact the finance office before retrying.',
            ];

            return response()->json([
                'status'  => 'failed',
                'message' => $messages[$e->getMessage()] ?? 'Payment could not be completed.',
                'error'   => $e->getMessage(),
            ], 422);

        } catch (\Throwable $e) {
            // \Throwable (not \Exception) so this also catches \Error subtypes —
            // e.g. a "Class ... not found" fatal from a stale production composer
            // autoloader (seen in production: a newly-deployed class file wasn't
            // picked up until `composer dump-autoload` ran). \Error is NOT caught by
            // `catch (\Exception)`, so before this change such a failure bypassed
            // every handler above (including the PaymentFailureException one) and
            // crashed raw, leaving the order stuck on 'pending' forever.
            //
            // Payment session expired between order creation and completion.
            // The DB transaction that detected this was rolled back (see handle()),
            // so apply the status update here, outside any transaction.
            if ($e->getMessage() === 'PAYMENT_SESSION_EXPIRED') {
                $orderRef = $request->input('order_reference');
                $user     = $request->user();
                if ($orderRef && $user) {
                    PaymentGatewayOrder::where('order_reference', $orderRef)
                        ->where('user_id', $user->id)
                        ->where('status', 'pending')
                        ->update(['status' => 'expired']);
                }
                Log::warning('CompletePayment: session expired', [
                    'order_reference' => $orderRef ?? 'unknown',
                    'user_id'         => $user?->id,
                ]);
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Payment session has expired. Please start a new payment.',
                    'error'   => 'PAYMENT_SESSION_EXPIRED',
                ], 422);
            }

            // NOTE: PAYMENT_JWT_INVALID / PAYMENT_DECLINED / PAYMENT_ORDER_BINDING_MISMATCH
            // normally throw PaymentFailureException and are handled in the catch
            // block above — they only reach here if PaymentFailureException itself
            // failed to load (see the \Throwable note above this catch block).

            // Log unexpected errors with full details
            Log::error('CompletePayment: Unexpected error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            // Outcome with CyberSource is unknown at this point (this is a genuinely
            // unexpected failure, not a confirmed decline) — don't leave the order
            // silently 'pending' forever. Same treatment as GATEWAY_TIMEOUT below:
            // mark it for manual admin review rather than implying it's safe to
            // blindly retry.
            $orderRef = $request->input('order_reference');
            $user     = $request->user();
            if ($orderRef && $user) {
                PaymentGatewayOrder::where('order_reference', $orderRef)
                    ->where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->update([
                        'status'               => 'gateway_timeout',
                        'cybersource_decision' => 'SYSTEM_ERROR',
                    ]);
            }

            throw $e;
        }
    }
}

