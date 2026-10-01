<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchedulingExaminationGradeDTO extends Data
{
    public function __construct(
        // user
        public int $program_id,
        public int $scheduling_examination_id,

        // system
        public int $created_by,
        public bool $is_generate_student_exam_report,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'program_id' => [new Required, new IntegerType],
            'scheduling_examination_id' => [new Required, new IntegerType],

            // system
            'created_by' => [new Required, new IntegerType],

        ];
    }
}
