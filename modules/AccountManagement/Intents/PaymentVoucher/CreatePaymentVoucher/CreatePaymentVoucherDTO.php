<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\CreatePaymentVoucher;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePaymentVoucherDTO extends Data
{
    public function __construct(
        // user
        public mixed $payment_voucher_type,
        public mixed $purchase_order_id,
        public mixed $expense_note_id,
        public mixed $amount,
        public mixed $narration,
        public mixed $payment_method,
        public mixed $cash_account_id,
        public mixed $cash_paid_date,
        public mixed $bank_account_id,
        public mixed $bank_transfer_date,
        public mixed $bank_transfer_reference_number,
        public mixed $check_type,
        public mixed $check_bank_account_id,
        public mixed $check_number,
        public mixed $check_issued_date,
        public mixed $check_date,
        public mixed $payment_issued_by_id,
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
            // user

            // system
            'created_by' => [new Required],
        ];
    }
}
