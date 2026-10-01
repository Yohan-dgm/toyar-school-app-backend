<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\UpdateExpenseCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExpenseCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $expense_type_id,
        public string $name,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'expense_type_id' => [new Required],
            'name' => [new Required],
            // system
        ];
    }
}
