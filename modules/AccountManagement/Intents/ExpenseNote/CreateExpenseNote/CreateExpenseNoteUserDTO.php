<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\CreateExpenseNote;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExpenseNoteUserDTO extends Data
{
    public function __construct(
        // user
        public mixed $date,
        public mixed $expense_party_id,
        public mixed $general_expense_party_info,
        public mixed $expense_type_id,
        public mixed $expense_category_id,
        public mixed $amount,
        public mixed $office_notes,
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
