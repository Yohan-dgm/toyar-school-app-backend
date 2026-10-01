<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\UpdateSchedulingExamination;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade\CreateSchedulingExaminationGradeAction;
use Modules\ExamManagement\Intents\SchedulingExaminationGrade\CreateSchedulingExaminationGrade\CreateSchedulingExaminationGradeUserDTO;
use Modules\ExamManagement\Models\SchedulingExamination;
use Modules\ExamManagement\Models\SchedulingExaminationGrade;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;
use Modules\ExamManagement\Models\SchedulingExaminationStatus;
use Modules\ExamManagement\Models\SchedulingExaminationSubjectPaper;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ExamManagement\Models\StudentSubjectMark;

class UpdateSchedulingExaminationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSchedulingExaminationUserDTO = UpdateSchedulingExaminationUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];
        $system_data['scheduling_examination_status_type_id'] = 1;
        // Save Scheduling Examination Status
        $system_data['scheduling_examination_id'] = $updateSchedulingExaminationUserDTO['id'];
        $system_data['scheduling_examination_status_type_id'] = 1;
        SchedulingExaminationStatus::create($system_data);

        // System Data Validation
        $updateSchedulingExaminationSystemDTO = UpdateSchedulingExaminationSystemDTO::validate($system_data);
        // Final Data Validation

        $updateSchedulingExaminationDTO = UpdateSchedulingExaminationDTO::validate(array_merge($updateSchedulingExaminationUserDTO, $updateSchedulingExaminationSystemDTO));
        // Save In Database
        SchedulingExamination::where('id', $updateSchedulingExaminationUserDTO['id'])->update($updateSchedulingExaminationDTO);
        $scheduling_examination = SchedulingExamination::find($updateSchedulingExaminationUserDTO['id']);

        ///////////////////////////////////////////////
        // $schedulingExaminationsGradeList = $updateSchedulingExaminationUserDTO['scheduling_examinations_grade_list'] ?? [];
        // $alredySaveServerSideExistingGradeIdList = SchedulingExaminationGrade::where('scheduling_examination_id', $updateSchedulingExaminationUserDTO['id'])->pluck('id')->toArray();
        // $schedulingIds = array_column($schedulingExaminationsGradeList, 'id');
        // // Step 2: Find IDs in already saved list that are NOT in scheduling list
        // $notInScheduling = array_diff($alredySaveServerSideExistingGradeIdList, $schedulingIds);
        // print_r($notInScheduling);

        // if (count($notInScheduling) > 0) {
        //     foreach ($notInScheduling as $id) {
        //         foreach ($schedulingExaminationsGradeList as $scheduling_examinations_grade_list) {
        //             if ($id == $scheduling_examinations_grade_list['id']) {
        //             }
        //             // print_r($id);
        //             print_r($scheduling_examinations_grade_list['id']);
        //             print_r(", ");
        //         }
        //     }
        //     // SchedulingExaminationGrade::whereIn('id', $notInScheduling)->delete();
        // }

        //Delete existing items
        $schedulingExaminationsGradeList = SchedulingExaminationGrade::where('scheduling_examination_id', $updateSchedulingExaminationUserDTO['id'])->get();
        foreach ($schedulingExaminationsGradeList as $scheduling_examinations_grade_list) {
            $scheduling_examinations_grade_subject = SchedulingExaminationGradeSubject::where('scheduling_examination_grade_id', $scheduling_examinations_grade_list['id'])->get();
            //
            foreach ($scheduling_examinations_grade_subject as $scheduling_examinations_grade_subject_list) {
                //
                $student_exam_mark = StudentExamMark::where('scheduling_examination_grade_subject_id', $scheduling_examinations_grade_subject_list['id'])->get();
                if (count($student_exam_mark) > 0) {
                    foreach ($student_exam_mark as $student_exam_mark_list) {
                        StudentSubjectMark::where('student_exam_mark_id', $student_exam_mark_list['id'])->delete();
                        StudentExamMark::where('id', $student_exam_mark_list['id'])->delete();
                    }
                }
                SchedulingExaminationSubjectPaper::where('scheduling_examination_grade_subject_id', $scheduling_examinations_grade_subject_list['id'])->delete();
                SchedulingExaminationGradeSubject::where('id', $scheduling_examinations_grade_subject_list['id'])->delete();
            }
            SchedulingExaminationGrade::where('id', $scheduling_examinations_grade_list['id'])->delete();

            // print_r($scheduling_examinations_grade_list['id']);
        }

        //Save Scheduling Examination Grade
        if (count($updateSchedulingExaminationUserDTO['scheduling_examinations_grade_list']) > 0) {
            foreach ($updateSchedulingExaminationUserDTO['scheduling_examinations_grade_list'] as $scheduling_examinations_grade_list) {
                $scheduling_examinations_grade_list['scheduling_examination_id'] = $updateSchedulingExaminationUserDTO['id'];
                $scheduling_examinations_grade_user_dto = CreateSchedulingExaminationGradeUserDTO::validate($scheduling_examinations_grade_list);
                CreateSchedulingExaminationGradeAction::run($scheduling_examinations_grade_user_dto, $actionData);
            }
        }

        return $scheduling_examination;
    }
}
