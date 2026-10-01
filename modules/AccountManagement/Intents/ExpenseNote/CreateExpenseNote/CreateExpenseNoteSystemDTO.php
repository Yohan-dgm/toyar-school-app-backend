<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\CreateExpenseNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExpenseNoteSystemDTO extends Data
{
    public function __construct(
        public mixed $serial_number_prefix,
        public mixed $serial_number_digits,
        public mixed $serial_number_current_year,
        public mixed $serial_number_financial_year,
        public mixed $serial_number_suffix,
        public mixed $serial_number,
        public mixed $is_expense_note_complete,
        public mixed $expense_note_status_id,
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
