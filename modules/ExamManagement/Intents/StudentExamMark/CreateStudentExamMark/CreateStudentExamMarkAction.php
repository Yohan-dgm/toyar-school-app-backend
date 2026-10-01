<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\CreateStudentExamMark;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\StudentExamMark;

class CreateStudentExamMarkAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentExamMarkUserDTO = CreateStudentExamMarkUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createStudentExamMarkSystemDTO = CreateStudentExamMarkSystemDTO::validate($system_data);
        // Final Data Validation
        $createStudentExamMarkDTO = CreateStudentExamMarkDTO::validate(array_merge($createStudentExamMarkUserDTO, $createStudentExamMarkSystemDTO));

        // Save In Database
        $studentExamMark = StudentExamMark::create($createStudentExamMarkDTO);

        return $studentExamMark;
    }
}
