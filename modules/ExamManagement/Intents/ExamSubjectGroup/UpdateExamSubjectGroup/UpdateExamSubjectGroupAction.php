<?php

namespace Modules\ExamManagement\Intents\ExamSubjectGroup\UpdateExamSubjectGroup;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectGroup;

class UpdateExamSubjectGroupAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamSubjectGroupUserDTO = UpdateExamSubjectGroupUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateExamSubjectGroupSystemDTO = UpdateExamSubjectGroupSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamSubjectGroupDTO = UpdateExamSubjectGroupDTO::validate(array_merge($updateExamSubjectGroupUserDTO, $updateExamSubjectGroupSystemDTO));
        // Save In Database
        ExamSubjectGroup::where('id', $updateExamSubjectGroupUserDTO['id'])->update($updateExamSubjectGroupDTO);
        $exam_subject_group = ExamSubjectGroup::find($updateExamSubjectGroupUserDTO['id']);

        return $exam_subject_group;
    }
}
