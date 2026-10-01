<?php

namespace Modules\StudentManagement\Intents\StudentClass\CreateStudentClass;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentClassSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public bool $is_current_class,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
