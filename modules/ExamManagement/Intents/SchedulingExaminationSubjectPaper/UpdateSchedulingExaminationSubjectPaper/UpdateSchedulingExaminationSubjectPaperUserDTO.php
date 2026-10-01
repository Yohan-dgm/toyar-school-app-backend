<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationSubjectPaper\UpdateSchedulingExaminationSubjectPaper;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSchedulingExaminationSubjectPaperUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $program_id,
        public int $scheduling_examination_id,
        public array $scheduling_examinations_grade_subject_list,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'program_id' => [new Required, new IntegerType],
            'scheduling_examination_id' => [new Required, new IntegerType],
            'scheduling_examinations_grade_subject_list' => [new Required],
        ];
    }
}
