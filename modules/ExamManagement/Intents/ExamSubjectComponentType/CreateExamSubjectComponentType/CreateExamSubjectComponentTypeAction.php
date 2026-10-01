<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponentType\CreateExamSubjectComponentType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectComponentType;

class CreateExamSubjectComponentTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamSubjectComponentTypeUserDTO = CreateExamSubjectComponentTypeUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createExamSubjectComponentTypeSystemDTO = CreateExamSubjectComponentTypeSystemDTO::validate($system_data);
        // Final Data Validation
        $createExamSubjectComponentTypeDTO = CreateExamSubjectComponentTypeDTO::validate(array_merge($createExamSubjectComponentTypeUserDTO, $createExamSubjectComponentTypeSystemDTO));

        // Save In Database
        $examSubjectComponentType = ExamSubjectComponentType::create($createExamSubjectComponentTypeDTO);

        return $examSubjectComponentType;
    }
}
