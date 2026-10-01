<?php

namespace Modules\StudentManagement\Intents\StudentClass\CreateStudentClass;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentClassUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public int $term_id,
        public int $grade_level_class_id,
        public int $garde_promotion_demotion_item_id,
        public string $class_joined_date,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required],
            // system
        ];
    }
}
