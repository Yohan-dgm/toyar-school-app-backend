<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentExamReportListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $student_exam_report_count,
        public ?object $grade_level_class_student_count,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
