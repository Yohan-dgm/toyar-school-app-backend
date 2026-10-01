<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchedulingExaminationGradeUserDTO extends Data
{
    public function __construct(
        // user
        public int $program_id,
        public int $scheduling_examination_id,
        public array $scheduling_examinations_grade_subject_list,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'program_id' => [new Required, new IntegerType],
            'scheduling_examination_id' => [new Required, new IntegerType],
            'scheduling_examinations_grade_subject_list' => [new Required],
        ];
    }
}
