<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGradeSubject\CreateSchedulingExaminationGradeSubject;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Intents\SchedulingExaminationSubjectPaper\CreateSchedulingExaminationSubjectPaper\CreateSchedulingExaminationSubjectPaperAction;
use Modules\ExamManagement\Intents\SchedulingExaminationSubjectPaper\CreateSchedulingExaminationSubjectPaper\CreateSchedulingExaminationSubjectPaperUserDTO;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;

class CreateSchedulingExaminationGradeSubjectAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSchedulingExaminationGradeSubjectUserDTO = CreateSchedulingExaminationGradeSubjectUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];
        $system_data['is_all_marks_confirmed'] = false;

        // System Data Validation
        $createSchedulingExaminationGradeSubjectSystemDTO = CreateSchedulingExaminationGradeSubjectSystemDTO::validate($system_data);
        // Final Data Validation
        $createSchedulingExaminationGradeSubjectDTO = CreateSchedulingExaminationGradeSubjectDTO::validate(array_merge($createSchedulingExaminationGradeSubjectUserDTO, $createSchedulingExaminationGradeSubjectSystemDTO));

        // Save In Database
        $schedulingExaminationGradeSubject = SchedulingExaminationGradeSubject::create($createSchedulingExaminationGradeSubjectDTO);

        //Save Exam Student
        // $schedulingExaminationGrade = SchedulingExaminationGrade::where('id', $createSchedulingExaminationGradeSubjectUserDTO['scheduling_examination_grade_id'])->get()->first();
        // $program = Program::where('id', $schedulingExaminationGrade['program_id'])->get()->first();
        // $student = Student::where('grade_level_id', $program['grade_level_id'])->get();
        // if (count($student) > 0) {
        //     foreach ($student as $examSubjectGroup) {
        //         $studentExamMarkData = [];
        //         $studentExamMarkData['student_id'] = $examSubjectGroup['id'];
        //         $studentExamMarkData['created_by']     = $actionData['user_id'];
        //         $studentExamMarkData['scheduling_examination_grade_subject_id'] = $schedulingExaminationGradeSubject->id;
        //         $studentExamMark = StudentExamMark::create($studentExamMarkData);

        //         if (count($createSchedulingExaminationGradeSubjectUserDTO["scheduling_examinations_subject_paper_list"]) > 0) {
        //             foreach ($createSchedulingExaminationGradeSubjectUserDTO["scheduling_examinations_subject_paper_list"] as $scheduling_examinations_subject_paper_list) {
        //                 $scheduling_examinations_subject_paper_list["student_exam_mark_id"] = $studentExamMark->id;
        //                 $crete_student_subject_mark_user_dto = CreateStudentSubjectMarkUserDTO::validate($scheduling_examinations_subject_paper_list);
        //                 CreateStudentSubjectMarkAction::run($crete_student_subject_mark_user_dto, $actionData);
        //             }
        //         }
        //     }
        // }

        //Save Scheduling Examination Subject Paper
        if (count($createSchedulingExaminationGradeSubjectUserDTO['scheduling_examinations_subject_paper_list']) > 0) {
            foreach ($createSchedulingExaminationGradeSubjectUserDTO['scheduling_examinations_subject_paper_list'] as $scheduling_examinations_subject_paper_list) {
                $scheduling_examinations_subject_paper_list['scheduling_examination_grade_subject_id'] = $schedulingExaminationGradeSubject->id;
                $scheduling_examinations_grade_user_dto = CreateSchedulingExaminationSubjectPaperUserDTO::validate($scheduling_examinations_subject_paper_list);
                CreateSchedulingExaminationSubjectPaperAction::run($scheduling_examinations_grade_user_dto, $actionData);
            }
        }

        return $schedulingExaminationGradeSubject;
    }
}
