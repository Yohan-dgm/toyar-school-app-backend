<?php

namespace Modules\ExamManagement\Intents\ExamSubjectCategory\UpdateExamSubjectCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectCategory;

class UpdateExamSubjectCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamSubjectCategoryUserDTO = UpdateExamSubjectCategoryUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateExamSubjectCategorySystemDTO = UpdateExamSubjectCategorySystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamSubjectCategoryDTO = UpdateExamSubjectCategoryDTO::validate(array_merge($updateExamSubjectCategoryUserDTO, $updateExamSubjectCategorySystemDTO));
        // Save In Database
        ExamSubjectCategory::where('id', $updateExamSubjectCategoryUserDTO['id'])->update($updateExamSubjectCategoryDTO);
        $exam_subject_category = ExamSubjectCategory::find($updateExamSubjectCategoryUserDTO['id']);

        return $exam_subject_category;
    }
}
