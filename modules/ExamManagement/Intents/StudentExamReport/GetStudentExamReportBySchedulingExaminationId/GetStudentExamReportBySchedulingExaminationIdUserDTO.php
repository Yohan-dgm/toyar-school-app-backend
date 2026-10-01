<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportBySchedulingExaminationId;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentExamReportBySchedulingExaminationIdUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        // system

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required, new IntegerType],
            // system
        ];
    }
}
