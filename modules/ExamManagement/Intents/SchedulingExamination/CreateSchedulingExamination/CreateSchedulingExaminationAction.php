<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\CreateSchedulingExamination;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade\CreateSchedulingExaminationGradeAction;
use Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade\CreateSchedulingExaminationGradeUserDTO;
use Modules\ExamManagement\Models\SchedulingExamination;
use Modules\ExamManagement\Models\SchedulingExaminationStatus;

class CreateSchedulingExaminationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSchedulingExaminationUserDTO = CreateSchedulingExaminationUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];
        $system_data['scheduling_examination_status_id'] = 0;
        $system_data['scheduling_examination_status_type_id'] = 1;
        $system_data['is_generate_student_exam_report'] = false;

        // System Data Validation
        $createSchedulingExaminationSystemDTO = CreateSchedulingExaminationSystemDTO::validate($system_data);
        // Final Data Validation
        $createSchedulingExaminationDTO = CreateSchedulingExaminationDTO::validate(array_merge($createSchedulingExaminationUserDTO, $createSchedulingExaminationSystemDTO));

        // Save In Database
        $schedulingExamination = SchedulingExamination::create($createSchedulingExaminationDTO);

        // Save Scheduling Examination Status
        $statusData['scheduling_examination_id'] = $schedulingExamination->id;
        $statusData['scheduling_examination_status_type_id'] = 1;
        $status = SchedulingExaminationStatus::create($statusData);

        $updateSchedulingExaminationData['scheduling_examination_status_id'] = $status->id;
        SchedulingExamination::where('id', $schedulingExamination->id)->update($updateSchedulingExaminationData);

        //Save Scheduling Examination Grade
        if (count($createSchedulingExaminationUserDTO['scheduling_examinations_grade_list']) > 0) {
            foreach ($createSchedulingExaminationUserDTO['scheduling_examinations_grade_list'] as $scheduling_examinations_grade_list) {
                $scheduling_examinations_grade_list['scheduling_examination_id'] = $schedulingExamination->id;
                $scheduling_examinations_grade_user_dto = CreateSchedulingExaminationGradeUserDTO::validate($scheduling_examinations_grade_list);
                CreateSchedulingExaminationGradeAction::run($scheduling_examinations_grade_user_dto, $actionData);
            }
        }

        return $schedulingExamination;
    }
}
