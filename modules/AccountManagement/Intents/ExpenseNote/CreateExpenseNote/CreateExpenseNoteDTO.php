<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\CreateExpenseNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExpenseNoteDTO extends Data
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
        public mixed $is_active,
        public mixed $serial_number_prefix,
        public mixed $serial_number_digits,
        public mixed $serial_number_current_year,
        public mixed $serial_number_financial_year,
        public mixed $serial_number_suffix,
        public mixed $serial_number,
        public mixed $is_expense_note_complete,
        public mixed $expense_note_status_id,
        public mixed $created_by,
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
