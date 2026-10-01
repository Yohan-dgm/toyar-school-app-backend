<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationSubjectPaper\CreateSchedulingExaminationSubjectPaper;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchedulingExaminationSubjectPaperDTO extends Data
{
    public function __construct(
        // user
        public int $scheduling_examination_grade_subject_id,
        public string $paper_type,
        public string $name,
        public float $overall_mark,
        public float $duration_hours,
        public float $duration_minutes,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'scheduling_examination_grade_subject_id' => [new Required, new IntegerType],
            'paper_type' => [new Required, new StringType],
            'name' => [new Required, new StringType],
            'overall_mark' => [new Required],
            'duration_hours' => [new Required],
            'duration_minutes' => [new Required],

            // system
            'created_by' => [new Required, new IntegerType],

        ];
    }
}
