<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\CompletePayment;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CompletePaymentResDTO extends Data
{
    public function __construct(
        public string  $order_reference,
        public string  $status,
        public float   $amount,
        public string  $currency,
        public float   $service_fee_amount,
        public float   $total_charged_amount,
        public string  $invoice_type,
        public int     $invoice_id,
        public ?int    $receipt_voucher_id,
        public string  $message,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [];
    }
}
