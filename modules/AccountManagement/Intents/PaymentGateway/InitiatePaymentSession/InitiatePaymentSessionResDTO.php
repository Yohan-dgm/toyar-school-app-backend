<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\InitiatePaymentSession;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class InitiatePaymentSessionResDTO extends Data
{
    public function __construct(
        public string $capture_context,
        public string $client_library_url,
        public ?string $client_library_integrity,
        public string $order_reference,
        public float  $amount,
        public string $currency,
        public float  $service_fee_amount,
        public float  $total_charged_amount,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [];
    }
}
