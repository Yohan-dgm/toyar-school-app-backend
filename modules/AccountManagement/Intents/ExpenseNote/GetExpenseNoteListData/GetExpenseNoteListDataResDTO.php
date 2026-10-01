<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\GetExpenseNoteListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetExpenseNoteListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $expense_note_count,
        public ?object $expense_type_count,
        public ?object $due_payment_expense_count,
        public ?object $payment_completed_expense_count,
        public ?object $payment_due_expense_total_amount,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
