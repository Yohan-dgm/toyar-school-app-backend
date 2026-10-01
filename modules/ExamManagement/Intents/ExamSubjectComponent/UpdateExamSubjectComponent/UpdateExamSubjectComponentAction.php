<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponent\UpdateExamSubjectComponent;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectComponent;

class UpdateExamSubjectComponentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamSubjectComponentUserDTO = UpdateExamSubjectComponentUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateExamSubjectComponentSystemDTO = UpdateExamSubjectComponentSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamSubjectComponentDTO = UpdateExamSubjectComponentDTO::validate(array_merge($updateExamSubjectComponentUserDTO, $updateExamSubjectComponentSystemDTO));
        // Save In Database
        ExamSubjectComponent::where('id', $updateExamSubjectComponentUserDTO['id'])->update($updateExamSubjectComponentDTO);
        $exam_subject_component = ExamSubjectComponent::find($updateExamSubjectComponentUserDTO['id']);

        return $exam_subject_component;
    }
}
