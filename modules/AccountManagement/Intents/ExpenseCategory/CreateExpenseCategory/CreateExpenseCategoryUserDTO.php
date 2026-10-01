<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\CreateExpenseCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExpenseCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $expense_type_id,
        public string $name,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'expense_type_id' => [new Required],
            'name' => [new Required],
            // system
        ];
    }
}
