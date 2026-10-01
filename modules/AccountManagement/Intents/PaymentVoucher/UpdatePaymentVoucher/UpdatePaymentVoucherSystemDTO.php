<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\UpdatePaymentVoucher;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdatePaymentVoucherSystemDTO extends Data
{
    public function __construct(
        public mixed $payment_issued_date,
        public mixed $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
