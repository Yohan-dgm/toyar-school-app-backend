<?php

namespace Modules\EducatorManagement\Intents\Educator\UpdateEducator;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEducatorDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $employee_id,
        public int $educator_grade_id,

        // system
        public bool $is_active,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'employee_id' => [new Required, new IntegerType],
            'educator_grade_id' => [new Required, new IntegerType],

            // system
            'is_active' => [new Required, new BooleanType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
