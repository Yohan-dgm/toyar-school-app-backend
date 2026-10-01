<?php

namespace Modules\ExamManagement\Intents\StudentSubjectMark\CreateStudentSubjectMark;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentSubjectMarkDTO extends Data
{
    public function __construct(
        // user
        public int $student_exam_mark_id,
        public string $name,
        public string $mark_type,
        public float $overall_mark,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'student_exam_mark_id' => [new Required, new IntegerType],
            'name' => [new Required, new StringType],
            'mark_type' => [new Required, new StringType],
            'overall_mark' => [new Required],

            // system
            'created_by' => [new Required, new IntegerType],

        ];
    }
}
