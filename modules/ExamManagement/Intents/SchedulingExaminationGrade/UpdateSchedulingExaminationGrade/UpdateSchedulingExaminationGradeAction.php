<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\UpdateSchedulingExaminationGrade;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationGrade;

class UpdateSchedulingExaminationGradeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSchedulingExaminationGradeUserDTO = UpdateSchedulingExaminationGradeUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateSchedulingExaminationGradeSystemDTO = UpdateSchedulingExaminationGradeSystemDTO::validate($system_data);
        // Final Data Validation

        $updateSchedulingExaminationGradeDTO = UpdateSchedulingExaminationGradeDTO::validate(array_merge($updateSchedulingExaminationGradeUserDTO, $updateSchedulingExaminationGradeSystemDTO));
        // Save In Database
        SchedulingExaminationGrade::where('id', $updateSchedulingExaminationGradeUserDTO['id'])->update($updateSchedulingExaminationGradeDTO);
        $scheduling_examination_grade = SchedulingExaminationGrade::find($updateSchedulingExaminationGradeUserDTO['id']);

        return $scheduling_examination_grade;
    }
}
