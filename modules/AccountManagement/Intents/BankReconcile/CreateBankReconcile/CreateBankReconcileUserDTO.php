<?php

namespace Modules\AccountManagement\Intents\BankReconcile\CreateBankReconcile;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateBankReconcileUserDTO extends Data
{
    public function __construct(
        // user
        public int $bank_statement_id,
        public mixed $reconciled_date,
        public mixed $amount,
        public mixed $naration,
        public mixed $receipt_voucher_list,
        public mixed $payment_voucher_list,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
