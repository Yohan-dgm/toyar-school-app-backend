<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\CreateIncomeCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateIncomeCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $income_type_id,
        public string $name,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'income_type_id' => [new Required],
            'name' => [new Required],
            // system
        ];
    }
}
