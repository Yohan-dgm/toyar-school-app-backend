<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\ApproveSchedulingExamination;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Intents\StudentSubjectMark\CreateStudentSubjectMark\CreateStudentSubjectMarkAction;
use Modules\ExamManagement\Intents\StudentSubjectMark\CreateStudentSubjectMark\CreateStudentSubjectMarkUserDTO;
use Modules\ExamManagement\Models\SchedulingExamination;
use Modules\ExamManagement\Models\SchedulingExaminationGrade;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;
use Modules\ExamManagement\Models\SchedulingExaminationStatus;
use Modules\ExamManagement\Models\SchedulingExaminationSubjectPaper;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ProgramManagement\Models\Program;
use Modules\StudentManagement\Models\Student;

class ApproveSchedulingExaminationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $approveSchedulingExaminationUserDTO = ApproveSchedulingExaminationUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];
        $system_data['scheduling_examination_status_id'] = 0;
        $system_data['scheduling_examination_status_type_id'] = 2;
        $system_data['approved_by'] = $actionData['user_id'];

        // System Data Validation
        $approveSchedulingExaminationSystemDTO = ApproveSchedulingExaminationSystemDTO::validate($system_data);
        // Final Data Validation
        $approveSchedulingExaminationDTO = ApproveSchedulingExaminationDTO::validate(array_merge($approveSchedulingExaminationUserDTO, $approveSchedulingExaminationSystemDTO));

        // Save In Database
        // SchedulingExamination::where('id', $approveSchedulingExaminationUserDTO['id'])->update($approveSchedulingExaminationDTO);

        // Save Scheduling Examination Status
        $statusData['scheduling_examination_id'] = $approveSchedulingExaminationUserDTO['id'];
        $statusData['scheduling_examination_status_type_id'] = 2;
        $status = SchedulingExaminationStatus::create($statusData);

        $approveSchedulingExaminationDTO['scheduling_examination_status_id'] = $status->id;
        $schedulingExamination = SchedulingExamination::where('id', $approveSchedulingExaminationUserDTO['id'])->update($approveSchedulingExaminationDTO);

        // exam student
        $schedulingExaminationsGradeList = SchedulingExaminationGrade::where('scheduling_examination_id', $approveSchedulingExaminationUserDTO['id'])->get();
        foreach ($schedulingExaminationsGradeList as $scheduling_examinations_grade_list) {
            $scheduling_examinations_grade_subject = SchedulingExaminationGradeSubject::where('scheduling_examination_grade_id', $scheduling_examinations_grade_list['id'])->get();
            //
            foreach ($scheduling_examinations_grade_subject as $scheduling_examinations_grade_subject_list) {
                //
                $schedulingExaminationGrade = SchedulingExaminationGrade::where('id', $scheduling_examinations_grade_list['id'])->get()->first();
                $program = Program::where('id', $schedulingExaminationGrade['program_id'])->get()->first();
                $student = Student::where('grade_level_id', $program['grade_level_id'])->get();
                if (count($student) > 0) {
                    foreach ($student as $examSubjectGroup) {
                        $studentExamMarkData = [];
                        $studentExamMarkData['student_id'] = $examSubjectGroup['id'];
                        $studentExamMarkData['created_by'] = $actionData['user_id'];
                        $studentExamMarkData['is_active'] = true;
                        $studentExamMarkData['is_mark_added'] = false;
                        $studentExamMarkData['scheduling_examination_grade_subject_id'] = $scheduling_examinations_grade_subject_list->id;
                        $studentExamMark = StudentExamMark::create($studentExamMarkData);

                        $shdeulingExaminationSubjectPaper = SchedulingExaminationSubjectPaper::where('scheduling_examination_grade_subject_id', $scheduling_examinations_grade_subject_list['id'])->get();
                        if (count($shdeulingExaminationSubjectPaper) > 0) {
                            foreach ($shdeulingExaminationSubjectPaper as $shdeulingExaminationSubjectPaperList) {
                                $shdeulingExaminationSubjectPaperList['student_exam_mark_id'] = $studentExamMark->id;
                                $shdeulingExaminationSubjectPaperList['mark_type'] = $shdeulingExaminationSubjectPaperList->paper_type;
                                $crete_student_subject_mark_user_dto = CreateStudentSubjectMarkUserDTO::validate($shdeulingExaminationSubjectPaperList);
                                CreateStudentSubjectMarkAction::run($crete_student_subject_mark_user_dto, $actionData);
                            }
                        }
                    }
                }
            }
        }

        return $schedulingExamination;
    }
}
