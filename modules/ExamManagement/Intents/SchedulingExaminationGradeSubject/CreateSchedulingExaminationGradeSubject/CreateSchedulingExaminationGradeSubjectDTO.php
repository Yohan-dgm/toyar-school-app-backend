<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGradeSubject\CreateSchedulingExaminationGradeSubject;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchedulingExaminationGradeSubjectDTO extends Data
{
    public function __construct(
        // user
        public int $subject_id,
        public int $scheduling_examination_grade_id,

        // system
        public int $created_by,
        public bool $is_all_marks_confirmed,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'subject_id' => [new Required, new IntegerType],
            'scheduling_examination_grade_id' => [new Required, new IntegerType],

            // system
            'created_by' => [new Required, new IntegerType],

        ];
    }
}
