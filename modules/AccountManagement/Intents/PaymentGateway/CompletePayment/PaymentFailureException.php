<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\CompletePayment;

/**
 * Signals a payment failure detected inside CompletePaymentAction (JWT invalid,
 * card declined, order-binding mismatch).
 *
 * CompletePaymentAction runs inside the DB::transaction() opened by
 * CompletePaymentIntent::handle() — any exception thrown from within it rolls
 * that transaction back, so the order's status/decision/reference cannot be
 * persisted at the point of failure. This exception carries that data back to
 * CompletePaymentIntent::asController(), which applies it in a standalone
 * query after the transaction has already rolled back (same pattern used for
 * the ConnectionException/gateway_timeout and expired-session cases).
 */
class PaymentFailureException extends \Exception
{
    public function __construct(
        string $errorCode,
        public readonly ?string $cybersourceDecision = null,
        public readonly ?string $cybersourceReference = null,
    ) {
        parent::__construct($errorCode);
    }
}
