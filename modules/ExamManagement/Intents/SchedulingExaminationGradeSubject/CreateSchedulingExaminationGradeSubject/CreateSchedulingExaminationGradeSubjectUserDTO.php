<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGradeSubject\CreateSchedulingExaminationGradeSubject;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchedulingExaminationGradeSubjectUserDTO extends Data
{
    public function __construct(
        // user
        public int $subject_id,
        public int $scheduling_examination_grade_id,
        public array $scheduling_examinations_subject_paper_list,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'subject_id' => [new Required, new IntegerType],
            'scheduling_examination_grade_id' => [new Required, new IntegerType],
            'scheduling_examinations_subject_paper_list' => [new Required],
        ];
    }
}
