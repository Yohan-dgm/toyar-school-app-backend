<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponent\CreateExamSubjectComponent;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ItemRate;
use Modules\ExamManagement\Models\ExamSubjectComponent;

class CreateExamSubjectComponentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamSubjectComponentUserDTO = CreateExamSubjectComponentUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createExamSubjectComponentSystemDTO = CreateExamSubjectComponentSystemDTO::validate($system_data);
        // Final Data Validation
        $createExamSubjectComponentDTO = CreateExamSubjectComponentDTO::validate(array_merge($createExamSubjectComponentUserDTO, $createExamSubjectComponentSystemDTO));

        // Save In Database
        $examSubjectComponent = ExamSubjectComponent::create($createExamSubjectComponentDTO);

        // Item Rate Save
        ItemRate::where('item_type', 'ExamSubjectComponent')->where('exam_subject_component_id', $examSubjectComponent->id)->update(['is_active' => 0]);
        $ExamSubjectComponentRateVersion = ItemRate::where('item_type', 'ExamSubjectComponent')->where('exam_subject_component_id', $examSubjectComponent->id)->max('version') ?? 0;
        $ExamSubjectComponentRateData['version'] = $ExamSubjectComponentRateVersion + 1;
        $ExamSubjectComponentRateData['rate'] = 0;
        $ExamSubjectComponentRateData['exam_subject_component_id'] = $examSubjectComponent->id;
        $ExamSubjectComponentRateData['item_type'] = 'ExamSubjectComponent';
        $ExamSubjectComponentRateData['created_by'] = $actionData['user_id'];
        $ExamSubjectComponentRateData['is_active'] = 1;
        ItemRate::create($ExamSubjectComponentRateData);

        return $examSubjectComponent;
    }
}
