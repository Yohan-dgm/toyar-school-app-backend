<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\UpdateExpenseCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExpenseCategoryDTO extends Data
{
    public function __construct(
        // user
        public int $expense_type_id,
        public string $name,

        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'expense_type_id' => [new Required],
            'name' => [new Required],

            // system
            'updated_by' => [new Required],
        ];
    }
}
