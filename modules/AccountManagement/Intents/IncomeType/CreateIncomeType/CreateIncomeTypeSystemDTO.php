<?php

namespace Modules\AccountManagement\Intents\IncomeType\CreateIncomeType;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateIncomeTypeSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
