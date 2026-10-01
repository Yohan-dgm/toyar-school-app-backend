<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\UpdatePaymentVoucher;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdatePaymentVoucherUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
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
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            // system
        ];
    }
}
