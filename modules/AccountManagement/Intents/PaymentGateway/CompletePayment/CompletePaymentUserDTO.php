<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\CompletePayment;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CompletePaymentUserDTO extends Data
{
    public function __construct(
        public string $transient_token,
        public string $order_reference,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'transient_token'  => ['required', 'string'],
            'order_reference'  => ['required', 'string', 'uuid'],
        ];
    }
}
