<?php

namespace Modules\ExamManagement\Intents\StudentExamData\GetStudentExamData;

use Spatie\LaravelData\Data;

class GetStudentExamDataUserDTO extends Data
{
    public function __construct(
        public int $student_id,
    ) {}
}
