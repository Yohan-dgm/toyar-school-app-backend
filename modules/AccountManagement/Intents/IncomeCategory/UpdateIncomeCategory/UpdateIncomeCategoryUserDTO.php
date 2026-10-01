<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\UpdateIncomeCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateIncomeCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $income_type_id,
        public string $name,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'income_type_id' => [new Required],
            'name' => [new Required],
            // system
        ];
    }
}
