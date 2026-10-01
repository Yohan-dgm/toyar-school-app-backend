<?php

namespace Modules\ExamManagement\Intents\ExamSubject\CreateExamSubject;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ItemRate;
use Modules\ExamManagement\Models\ExamSubject;

class CreateExamSubjectAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamSubjectUserDTO = CreateExamSubjectUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createExamSubjectSystemDTO = CreateExamSubjectSystemDTO::validate($system_data);
        // Final Data Validation
        $createExamSubjectDTO = CreateExamSubjectDTO::validate(array_merge($createExamSubjectUserDTO, $createExamSubjectSystemDTO));

        // Save In Database
        $examSubject = ExamSubject::create($createExamSubjectDTO);

        // $examSubjectGroupList = [];
        // if (array_key_exists('exam_subject_group_list', $createExamSubjectUserDTO) && !is_null($createExamSubjectUserDTO['exam_subject_group_list']) && $createExamSubjectUserDTO['exam_subject_group_list'] != "null" && count($createExamSubjectUserDTO['exam_subject_group_list']) > 0) {
        //     foreach ($createExamSubjectUserDTO['exam_subject_group_list'] as $examSubjectGroup) {
        //         array_push($examSubjectGroupList, $examSubjectGroup['id']);
        //     }
        // }
        // $examSubject->exam_subject_group_list()->sync($examSubjectGroupList);

        // Item Rate Save
        ItemRate::where('item_type', 'Exam Subject')->where('exam_subject_id', $examSubject->id)->update(['is_active' => 0]);
        $ExamSubjectRateVersion = ItemRate::where('item_type', 'Exam Subject')->where('exam_subject_id', $examSubject->id)->max('version') ?? 0;
        $ExamSubjectRateData['version'] = $ExamSubjectRateVersion + 1;
        $ExamSubjectRateData['rate'] = $createExamSubjectUserDTO['exam_subject_fee'];
        $ExamSubjectRateData['exam_subject_id'] = $examSubject->id;
        $ExamSubjectRateData['item_type'] = 'Exam Subject';
        $ExamSubjectRateData['created_by'] = $actionData['created_by'];
        $ExamSubjectRateData['is_active'] = 1;
        ItemRate::create($ExamSubjectRateData);

        return $examSubject;
    }
}
