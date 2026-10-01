<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\UpdateStudentExamMark;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ExamManagement\Models\StudentSubjectMark;
use Modules\LogManagement\Intents\ExamLog\CreateExamLog\CreateExamLogAction;

class UpdateStudentExamMarkAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateStudentExamMarkUserDTO = UpdateStudentExamMarkUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['mark_added_by'] = $actionData['updated_by'];
        $system_data['is_mark_added'] = true;

        // System Data Validation
        $updateStudentExamMarkSystemDTO = UpdateStudentExamMarkSystemDTO::validate($system_data);
        // Final Data Validation
        $updateStudentExamMarkDTO = UpdateStudentExamMarkDTO::validate(array_merge($updateStudentExamMarkUserDTO, $updateStudentExamMarkSystemDTO));

        // StudentSubjectMark::where('student_exam_mark_id', $updateStudentExamMarkUserDTO['id'])->delete();
        if ($updateStudentExamMarkDTO['present_type'] == 'Absent') {
            $updateStudentExamMarkDTO['grading'] = '-';
            $updateStudentExamMarkDTO['subject_total_mark'] = 0;
            $updateStudentExamMarkDTO['subject_overall_mark_percentage'] = 0;
            //
        } elseif ($updateStudentExamMarkDTO['present_type'] == 'Present') {
            if ($updateStudentExamMarkUserDTO['student_subject_mark_list'] != null) {
                foreach ($updateStudentExamMarkUserDTO['student_subject_mark_list'] as $key => $value) {
                    $studentSubjectMarkData = [];
                    $studentSubjectMarkData['student_exam_mark_id'] = $updateStudentExamMarkUserDTO['id'];
                    $studentSubjectMarkData['mark_type'] = $value['mark_type'];
                    $studentSubjectMarkData['name'] = $value['name'];
                    $studentSubjectMarkData['mark'] = $value['mark'];
                    $studentSubjectMarkData['updated_by'] = $actionData['updated_by'];

                    StudentSubjectMark::where('id', $value['id'])->update($studentSubjectMarkData);
                }

                // Exam Report save
                // $studentExamMark = StudentExamMark::where('id', $updateStudentExamMarkUserDTO['id'])->first();
                // $schedulingExaminationGradeSubject = SchedulingExaminationGradeSubject::where('id', $studentExamMark['scheduling_examination_grade_subject_id'])->first();
                // $studentReportUserData['student_id'] = $studentExamMark['student_id'];
                // $studentReportUserData['sheduling_examination_grade_id'] = $schedulingExaminationGradeSubject['scheduling_examination_grade_id'];
            }
            $updateStudentExamMarkDTO['subject_overall_mark_percentage'] = intval($updateStudentExamMarkDTO['subject_overall_mark_percentage']);
        }
        // Save In Database
        StudentExamMark::where('id', $updateStudentExamMarkUserDTO['id'])->update($updateStudentExamMarkDTO);

        $studentExamMarkData = StudentExamMark::where('id', $updateStudentExamMarkUserDTO['id'])
            ->with('student.grade_level_class')
            ->with('scheduling_examination_grade_subject_item.subject')->first();
        // create exam log
        $logData['description'] = '[STATUS: Update Student Exam Mark, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', SUBJECT: '.$studentExamMarkData['scheduling_examination_grade_subject_item']['subject']['name'].' '.$studentExamMarkData['student']['grade_level_class']['name'].', STUDENT: '.$studentExamMarkData['student']['full_name_with_title'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Student Exam Mark';
        CreateExamLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        $studentExamMark = StudentExamMark::where('id', $updateStudentExamMarkUserDTO['id'])->first();

        return $studentExamMark;
    }
}
