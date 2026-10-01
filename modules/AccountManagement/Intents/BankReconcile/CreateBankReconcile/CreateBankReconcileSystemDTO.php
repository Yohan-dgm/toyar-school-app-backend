<?php

namespace Modules\AccountManagement\Intents\BankReconcile\CreateBankReconcile;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateBankReconcileSystemDTO extends Data
{
    public function __construct(
        public mixed $bank_account_id,
        public mixed $transaction_type, //deposit, withdrawal
        public mixed $reconciled_by,
        public mixed $running_balance,
        public mixed $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
