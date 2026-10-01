<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\UpdateSchedulingExamination;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSchedulingExaminationUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $exam_type,
        public string $exam_title,
        public string $exam_start_time,
        public Date $exam_start_date,
        public string $exam_end_time,
        public Date $exam_end_date,
        public int $term_id,
        public ?string $description,
        public array $scheduling_examinations_grade_list,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'exam_type' => [new Required, new StringType],
            'exam_title' => [new Required, new StringType],
            'exam_start_time' => [new Required, new StringType],
            'exam_start_date' => [new Required, new Date],
            'exam_end_time' => [new Required, new StringType],
            'exam_end_date' => [new Required, new Date],
            'term_id' => [new Required, new IntegerType],
            'scheduling_examinations_grade_list' => [new Required],
        ];
    }
}
