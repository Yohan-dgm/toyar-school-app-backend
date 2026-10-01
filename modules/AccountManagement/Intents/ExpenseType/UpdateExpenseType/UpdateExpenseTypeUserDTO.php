<?php

namespace Modules\AccountManagement\Intents\ExpenseType\UpdateExpenseType;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExpenseTypeUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $name,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'name' => [new Required, new StringType, new Unique('expense_type', 'name')],
            // system
        ];
    }
}
