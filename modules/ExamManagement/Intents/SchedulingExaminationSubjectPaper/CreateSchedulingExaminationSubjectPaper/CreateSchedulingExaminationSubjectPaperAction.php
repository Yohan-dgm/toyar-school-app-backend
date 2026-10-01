<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationSubjectPaper\CreateSchedulingExaminationSubjectPaper;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationSubjectPaper;

class CreateSchedulingExaminationSubjectPaperAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSchedulingExaminationSubjectPaperUserDTO = CreateSchedulingExaminationSubjectPaperUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createSchedulingExaminationSubjectPaperSystemDTO = CreateSchedulingExaminationSubjectPaperSystemDTO::validate($system_data);
        // Final Data Validation
        $createSchedulingExaminationSubjectPaperDTO = CreateSchedulingExaminationSubjectPaperDTO::validate(array_merge($createSchedulingExaminationSubjectPaperUserDTO, $createSchedulingExaminationSubjectPaperSystemDTO));

        // Save In Database
        $schedulingExaminationSubjectPaper = SchedulingExaminationSubjectPaper::create($createSchedulingExaminationSubjectPaperDTO);

        return $schedulingExaminationSubjectPaper;
    }
}
