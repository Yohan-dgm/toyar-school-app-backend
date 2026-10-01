<?php

namespace Modules\ExamManagement\Intents\ExamSubject\UpdateExamSubject;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubject;

class UpdateExamSubjectAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamSubjectUserDTO = UpdateExamSubjectUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateExamSubjectSystemDTO = UpdateExamSubjectSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamSubjectDTO = UpdateExamSubjectDTO::validate(array_merge($updateExamSubjectUserDTO, $updateExamSubjectSystemDTO));
        // Save In Database
        ExamSubject::where('id', $updateExamSubjectUserDTO['id'])->update($updateExamSubjectDTO);

        // $examSubjectGroupList = [];
        // if (array_key_exists('exam_subject_group_list', $updateExamSubjectUserDTO) && !is_null($updateExamSubjectUserDTO['exam_subject_group_list']) && $updateExamSubjectUserDTO['exam_subject_group_list'] != "null" && count($updateExamSubjectUserDTO['exam_subject_group_list']) > 0) {
        //     foreach ($updateExamSubjectUserDTO['exam_subject_group_list'] as $examSubjectGroup) {
        //         array_push($examSubjectGroupList, $examSubjectGroup['id']);
        //     }
        // }
        // $examSubject->exam_subject_group_list()->sync($examSubjectGroupList);

        $examSubject = ExamSubject::where('id', $updateExamSubjectUserDTO['id'])->first();

        return $examSubject;
    }
}
