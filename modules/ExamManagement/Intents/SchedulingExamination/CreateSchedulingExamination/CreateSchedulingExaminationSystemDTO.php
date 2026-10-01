<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\CreateSchedulingExamination;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchedulingExaminationSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public int $scheduling_examination_status_id,
        public int $scheduling_examination_status_type_id,
        public bool $is_generate_student_exam_report,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required, new IntegerType],
            'scheduling_examination_status_id' => [new Required, new IntegerType],
            'scheduling_examination_status_type_id' => [new Required, new IntegerType],
            'is_generate_student_exam_report' => [new Required, new BooleanType],
        ];
    }
}
