<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\CreatePaymentVoucher;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePaymentVoucherSystemDTO extends Data
{
    public function __construct(
        // system
        public mixed $payment_issued_date,
        public mixed $serial_number_prefix,
        public mixed $serial_number_digits,
        public mixed $serial_number_current_year,
        public mixed $serial_number_financial_year,
        public mixed $serial_number_suffix,
        public mixed $serial_number,
        public mixed $created_by,
        public mixed $is_active,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
