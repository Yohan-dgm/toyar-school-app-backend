<?php

namespace Modules\AccountManagement\Intents\ExpenseType\CreateExpenseType;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExpenseTypeDTO extends Data
{
    public function __construct(
        // user
        public string $name,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType, new Unique('expense_type', 'name')],

            // system
            'created_by' => [new Required],
        ];
    }
}
