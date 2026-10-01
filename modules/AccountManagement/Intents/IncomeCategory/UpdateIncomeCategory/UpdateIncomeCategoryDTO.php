<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\UpdateIncomeCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateIncomeCategoryDTO extends Data
{
    public function __construct(
        // user
        public int $income_type_id,
        public string $name,

        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'income_type_id' => [new Required],
            'name' => [new Required],

            // system
            'updated_by' => [new Required],
        ];
    }
}
