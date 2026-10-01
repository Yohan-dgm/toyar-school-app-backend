<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportBySchedulingExaminationId;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentExamReportBySchedulingExaminationIdResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?object $student_info,
        public ?array $exam_reports,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
