<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchedulingExaminationGradeSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public bool $is_generate_student_exam_report,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
