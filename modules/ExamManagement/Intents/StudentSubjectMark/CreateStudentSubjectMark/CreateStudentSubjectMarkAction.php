<?php

namespace Modules\ExamManagement\Intents\StudentSubjectMark\CreateStudentSubjectMark;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\StudentSubjectMark;

class CreateStudentSubjectMarkAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentSubjectMarkUserDTO = CreateStudentSubjectMarkUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createStudentSubjectMarkSystemDTO = CreateStudentSubjectMarkSystemDTO::validate($system_data);
        // Final Data Validation
        $createStudentSubjectMarkDTO = CreateStudentSubjectMarkDTO::validate(array_merge($createStudentSubjectMarkUserDTO, $createStudentSubjectMarkSystemDTO));

        // Save In Database
        $studentSubjectMark = StudentSubjectMark::create($createStudentSubjectMarkDTO);

        return $studentSubjectMark;
    }
}
