<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\UpdateExpenseNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExpenseNoteSystemDTO extends Data
{
    public function __construct(
        public mixed $is_expense_note_complete,
        public mixed $expense_note_status_id,
        public mixed $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
