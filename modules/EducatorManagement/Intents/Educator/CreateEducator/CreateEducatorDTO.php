<?php

namespace Modules\EducatorManagement\Intents\Educator\CreateEducator;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEducatorDTO extends Data
{
    public function __construct(
        // user
        public int $employee_id,
        public int $educator_grade_id,

        // system
        public int $created_by,
        public bool $is_active,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'employee_id' => [new Required, new IntegerType],
            'educator_grade_id' => [new Required, new IntegerType],

            // system
            'created_by' => [new Required, new IntegerType],
            'is_active' => [new Required, new BooleanType],
        ];
    }
}
