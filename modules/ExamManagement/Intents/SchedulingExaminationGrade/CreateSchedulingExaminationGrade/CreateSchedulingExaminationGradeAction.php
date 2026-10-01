<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Intents\SchedulingExaminationGradeSubject\CreateSchedulingExaminationGradeSubject\CreateSchedulingExaminationGradeSubjectAction;
use Modules\ExamManagement\Intents\SchedulingExaminationGradeSubject\CreateSchedulingExaminationGradeSubject\CreateSchedulingExaminationGradeSubjectUserDTO;
use Modules\ExamManagement\Models\SchedulingExaminationGrade;

class CreateSchedulingExaminationGradeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSchedulingExaminationGradeUserDTO = CreateSchedulingExaminationGradeUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];
        $system_data['is_generate_student_exam_report'] = false;

        // System Data Validation
        $createSchedulingExaminationGradeSystemDTO = CreateSchedulingExaminationGradeSystemDTO::validate($system_data);
        // Final Data Validation
        $createSchedulingExaminationGradeDTO = CreateSchedulingExaminationGradeDTO::validate(array_merge($createSchedulingExaminationGradeUserDTO, $createSchedulingExaminationGradeSystemDTO));

        // Save In Database
        $schedulingExaminationGrade = SchedulingExaminationGrade::create($createSchedulingExaminationGradeDTO);
        //Save SchedulingExaminationGradeSubjectList , examQuizItem
        //Save Scheduling Examination Grade
        if (count($createSchedulingExaminationGradeUserDTO['scheduling_examinations_grade_subject_list']) > 0) {
            foreach ($createSchedulingExaminationGradeUserDTO['scheduling_examinations_grade_subject_list'] as $scheduling_examinations_grade_subject_list) {
                $scheduling_examinations_grade_subject_list['scheduling_examination_grade_id'] = $schedulingExaminationGrade->id;
                $scheduling_examinations_grade_user_dto = CreateSchedulingExaminationGradeSubjectUserDTO::validate($scheduling_examinations_grade_subject_list);
                CreateSchedulingExaminationGradeSubjectAction::run($scheduling_examinations_grade_user_dto, $actionData);
            }
        }

        return $schedulingExaminationGrade;
    }
}
