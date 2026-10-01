<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponentType\UpdateExamSubjectComponentType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectComponentType;

class UpdateExamSubjectComponentTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamSubjectComponentTypeUserDTO = UpdateExamSubjectComponentTypeUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateExamSubjectComponentTypeSystemDTO = UpdateExamSubjectComponentTypeSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamSubjectComponentTypeDTO = UpdateExamSubjectComponentTypeDTO::validate(array_merge($updateExamSubjectComponentTypeUserDTO, $updateExamSubjectComponentTypeSystemDTO));
        // Save In Database
        ExamSubjectComponentType::where('id', $updateExamSubjectComponentTypeUserDTO['id'])->update($updateExamSubjectComponentTypeDTO);
        $exam_subject_component = ExamSubjectComponentType::find($updateExamSubjectComponentTypeUserDTO['id']);

        return $exam_subject_component;
    }
}
