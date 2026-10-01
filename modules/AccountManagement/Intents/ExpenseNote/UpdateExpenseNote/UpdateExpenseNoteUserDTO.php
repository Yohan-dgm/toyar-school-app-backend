<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\UpdateExpenseNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExpenseNoteUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
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
            'id' => [new Required],
            // system
        ];
    }
}
