<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\UpdateStudentExamMark;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentExamMarkUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public float $subject_total_mark,
        public float $subject_overall_mark_percentage,
        public ?string $subject_comment,
        public bool $present_type,
        public string $grading,
        public ?array $student_subject_mark_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'subject_total_mark' => [new Required],
            'subject_overall_mark_percentage' => [new Required],
            // "subject_comment" => [new Required()],
            'present_type' => [new Required],
            'grading' => [new Required],
            // "student_subject_mark_list" => [new Required()],

        ];
    }
}
