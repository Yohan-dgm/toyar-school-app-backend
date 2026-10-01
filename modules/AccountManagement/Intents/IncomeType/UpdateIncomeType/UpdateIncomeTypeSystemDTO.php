<?php

namespace Modules\AccountManagement\Intents\IncomeType\UpdateIncomeType;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateIncomeTypeSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
