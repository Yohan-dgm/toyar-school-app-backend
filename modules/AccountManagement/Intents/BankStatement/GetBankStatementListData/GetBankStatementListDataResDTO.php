<?php

namespace Modules\AccountManagement\Intents\BankStatement\GetBankStatementListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetBankStatementListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $bank_statement_count,
        public ?object $pending_reconcile_bank_statement_count,
        public ?object $reconciled_bank_statement_count,
        public ?object $pending_reconcile_bank_statement_total_amount,
        public ?object $reconciled_bank_statement_total_amount,
        public ?object $bank_statement_transaction_type_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
