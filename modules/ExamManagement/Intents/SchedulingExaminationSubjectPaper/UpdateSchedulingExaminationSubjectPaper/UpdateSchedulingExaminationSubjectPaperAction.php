<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationSubjectPaper\UpdateSchedulingExaminationSubjectPaper;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationSubjectPaper;

class UpdateSchedulingExaminationSubjectPaperAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSchedulingExaminationSubjectPaperUserDTO = UpdateSchedulingExaminationSubjectPaperUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateSchedulingExaminationSubjectPaperSystemDTO = UpdateSchedulingExaminationSubjectPaperSystemDTO::validate($system_data);
        // Final Data Validation

        $updateSchedulingExaminationSubjectPaperDTO = UpdateSchedulingExaminationSubjectPaperDTO::validate(array_merge($updateSchedulingExaminationSubjectPaperUserDTO, $updateSchedulingExaminationSubjectPaperSystemDTO));
        // Save In Database
        // SchedulingExaminationSubjectPaper::where('id', $updateSchedulingExaminationSubjectPaperUserDTO['id'])->update($updateSchedulingExaminationSubjectPaperDTO);
        // $scheduling_examination_subject_paper = SchedulingExaminationSubjectPaper::find($updateSchedulingExaminationSubjectPaperUserDTO['id']);

        // return $scheduling_examination_subject_paper;
        return '';
    }
}
