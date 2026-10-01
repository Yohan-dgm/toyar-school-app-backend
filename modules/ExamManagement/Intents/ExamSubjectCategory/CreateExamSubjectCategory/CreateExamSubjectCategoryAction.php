<?php

namespace Modules\ExamManagement\Intents\ExamSubjectCategory\CreateExamSubjectCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectCategory;

class CreateExamSubjectCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamSubjectCategoryUserDTO = CreateExamSubjectCategoryUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createExamSubjectCategorySystemDTO = CreateExamSubjectCategorySystemDTO::validate($system_data);
        // Final Data Validation
        $createExamSubjectCategoryDTO = CreateExamSubjectCategoryDTO::validate(array_merge($createExamSubjectCategoryUserDTO, $createExamSubjectCategorySystemDTO));

        // Save In Database
        $examSubjectCategory = ExamSubjectCategory::create($createExamSubjectCategoryDTO);

        return $examSubjectCategory;
    }
}
