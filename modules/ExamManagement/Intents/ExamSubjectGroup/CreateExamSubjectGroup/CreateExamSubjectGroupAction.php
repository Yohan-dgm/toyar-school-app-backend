<?php

namespace Modules\ExamManagement\Intents\ExamSubjectGroup\CreateExamSubjectGroup;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectGroup;

class CreateExamSubjectGroupAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamSubjectGroupUserDTO = CreateExamSubjectGroupUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createExamSubjectGroupSystemDTO = CreateExamSubjectGroupSystemDTO::validate($system_data);
        // Final Data Validation
        $createExamSubjectGroupDTO = CreateExamSubjectGroupDTO::validate(array_merge($createExamSubjectGroupUserDTO, $createExamSubjectGroupSystemDTO));

        // Save In Database
        $examSubjectGroup = ExamSubjectGroup::create($createExamSubjectGroupDTO);

        return $examSubjectGroup;
    }
}
