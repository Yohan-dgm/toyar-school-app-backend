<?php

namespace Modules\ExamManagement\Intents\StudentExamData\GetStudentExamData;

use Spatie\LaravelData\Data;

class GetStudentExamDataResDTO extends Data
{
    public function __construct(
        public array $student_exam_marks,
        public array $quiz_marks,
        public array $exam_reports,
        public array $subject_marks,
    ) {}
}
