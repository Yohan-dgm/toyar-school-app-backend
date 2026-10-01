<?php

namespace Modules\ExamManagement\Intents\ExamQuizItem\UpdateExamQuizItem;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamQuizItem;

class UpdateExamQuizItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamQuizItemUserDTO = UpdateExamQuizItemUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateExamQuizItemSystemDTO = UpdateExamQuizItemSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamQuizItemDTO = UpdateExamQuizItemDTO::validate(array_merge($updateExamQuizItemUserDTO, $updateExamQuizItemSystemDTO));
        // Save In Database
        ExamQuizItem::where('id', $updateExamQuizItemUserDTO['id'])->update($updateExamQuizItemDTO);

        $examQuizItem = ExamQuizItem::where('id', $updateExamQuizItemUserDTO['id'])->first();

        return $examQuizItem;
    }
}
