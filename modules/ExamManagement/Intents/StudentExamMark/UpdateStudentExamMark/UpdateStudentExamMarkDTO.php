<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\UpdateStudentExamMark;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentExamMarkDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public float $subject_total_mark,
        public float $subject_overall_mark_percentage,
        public ?string $subject_comment,
        public string $grading,
        public string $present_type,

        // system
        public bool $is_mark_added,
        public int $mark_added_by,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'subject_total_mark' => [new Required],
            'subject_overall_mark_percentage' => [new Required],
            // "subject_comment" => [new Required()],
            'grading' => [new Required],
            'present_type' => [new Required],

            // system
            'mark_added_by' => [new Required, new IntegerType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
