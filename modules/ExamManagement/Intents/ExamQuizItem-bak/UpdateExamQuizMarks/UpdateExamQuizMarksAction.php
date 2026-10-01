<?php

namespace Modules\ExamManagement\Intents\ExamQuizItem\UpdateExamQuizMarks;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamQuizItem;

class UpdateExamQuizMarksAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamQuizMarksUserDTO = UpdateExamQuizMarksUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        // $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateExamQuizMarksSystemDTO = UpdateExamQuizMarksSystemDTO::validate($system_data);
        // Final Data Validation
        $updateExamQuizMarksDTO = UpdateExamQuizMarksDTO::validate(array_merge($updateExamQuizMarksUserDTO, $updateExamQuizMarksSystemDTO));
        // Save In Database
        // ExamQuizItem::where('id', $updateExamQuizMarksUserDTO['id'])->update($updateExamQuizMarksDTO);
        $pivot_id = $updateExamQuizMarksUserDTO['id'];
        $exam_quiz_item_id = $updateExamQuizMarksUserDTO['exam_quiz_item_id'];
        unset($updateExamQuizMarksDTO['id']);

        $updateExamQuizMarksDTO['present_type'] == 'Present' ? $updateExamQuizMarksDTO['is_absent'] = 0 : $updateExamQuizMarksDTO['is_absent'] = 1;
        unset($updateExamQuizMarksDTO['present_type']);

        $ExamQuizItem = ExamQuizItem::find($exam_quiz_item_id);
        $ExamQuizItem->student_list()->wherePivot('id', $pivot_id)->first()->pivot->update($updateExamQuizMarksDTO);
        // ->update($updateExamQuizMarksDTO)
        // $exam_quiz = ExamQuizItem::find($updateExamQuizMarksUserDTO['id']);

        return $ExamQuizItem;
    }
}
