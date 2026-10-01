<?php

namespace Modules\ExamManagement\Intents\ExamQuiz\CreateExamQuiz;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamQuiz;
use Modules\ExamManagement\Models\ExamQuizItem;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ProgramManagement\Models\Program;
use Modules\ProgramManagement\Models\Subject;
use Modules\StudentManagement\Models\Student;

class CreateExamQuizAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamQuizUserDTO = CreateExamQuizUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];
        $system_data['is_active'] = 1;
        $system_data['is_generate_student_exam_report'] = false;

        // System Data Validation
        $createExamQuizSystemDTO = CreateExamQuizSystemDTO::validate($system_data);
        // Final Data Validation
        $createExamQuizDTO = CreateExamQuizDTO::validate(array_merge($createExamQuizUserDTO, $createExamQuizSystemDTO));

        // Save In Database
        unset($createExamQuizDTO['subject_id']);
        $examQuiz = ExamQuiz::create($createExamQuizDTO);

        // Save examQuizItem
        $examQuizItemData = [];
        $examQuizItemData['exam_quiz_id'] = $examQuiz->id;
        $examQuizItemData['created_by'] = $actionData['user_id'];

        if ($createExamQuizDTO['exam_type'] == 'Quizzes' || $createExamQuizDTO['exam_type'] == 'Cambridge Exam') {
            $examQuizItemData['subject_id'] = $createExamQuizUserDTO['subject_id'];
            $examQuizItemData['subject_start_date'] = $createExamQuizDTO['exam_start_date'];
            $examQuizItemData['subject_end_date'] = $createExamQuizDTO['exam_end_date'];
            $examQuizItemData['subject_start_time'] = $createExamQuizDTO['exam_start_time'];
            $examQuizItemData['subject_end_time'] = $createExamQuizDTO['exam_end_time'];

            $examQuizItem = ExamQuizItem::create($examQuizItemData);

            $program = Program::where('id', $createExamQuizDTO['program_id'])->get()->first();
            $student = Student::where('grade_level_id', $program['grade_level_id'])->get();
            if (count($student) > 0) {
                foreach ($student as $examSubjectGroup) {
                    $studentExamMarkData = [];
                    $studentExamMarkData['student_id'] = $examSubjectGroup['id'];
                    $studentExamMarkData['created_by'] = $actionData['user_id'];
                    $studentExamMarkData['exam_quiz_item_id'] = $examQuizItem->id;
                    StudentExamMark::create($studentExamMarkData);
                }
            }
            //pvot
            // $studentList = [];
            // if (count($student) > 0) {
            //     foreach ($student as $examSubjectGroup) {
            //         array_push($studentList, $examSubjectGroup['id']);
            //     }
            // }
            // $examQuizItem->student_list()->sync($studentList);
        } else {

            $subject = Subject::where('program_id', $createExamQuizDTO['program_id'])->get();
            if (count($subject) > 0) {
                foreach ($subject as $subjectDate) {

                    $examQuizItemData['subject_start_date'] = $createExamQuizDTO['exam_start_date'];
                    $examQuizItemData['subject_end_date'] = $createExamQuizDTO['exam_end_date'];
                    $examQuizItemData['subject_start_time'] = $createExamQuizDTO['exam_start_time'];
                    $examQuizItemData['subject_end_time'] = $createExamQuizDTO['exam_end_time'];
                    $examQuizItemData['subject_id'] = $subjectDate['id'];

                    $examQuizItem = ExamQuizItem::create($examQuizItemData);

                    $program = Program::where('id', $createExamQuizDTO['program_id'])->get()->first();
                    $student = Student::where('grade_level_id', $program['grade_level_id'])->get();

                    if (count($student) > 0) {
                        foreach ($student as $examSubjectGroup) {
                            $studentExamMarkData = [];
                            $studentExamMarkData['student_id'] = $examSubjectGroup['id'];
                            $studentExamMarkData['created_by'] = $actionData['user_id'];
                            $studentExamMarkData['exam_quiz_item_id'] = $examQuizItem->id;
                            StudentExamMark::create($studentExamMarkData);
                        }
                    }
                    // pvot
                    // $studentList = [];
                    // if (count($student) > 0) {
                    //     foreach ($student as $examSubjectGroup) {
                    //         array_push($studentList, $examSubjectGroup['id']);
                    //         $studentList[$examSubjectGroup['id']] = [
                    //             "marks" => 0,
                    //         ];
                    //     }
                    // }
                    // $examQuizItem->student_list()->sync($studentList);

                }
            }
            // $getExamQuizItem = ExamQuizItem::where('exam_quiz_id', $examQuiz->id)->get();

            // $program = Program::where('id', $createExamQuizDTO['program_id'])->get()->first();
            // $student = Student::where('grade_level_id', $program['grade_level_id'])->get();
            // $studentList = [];
            // if (count($student) > 0) {
            //     foreach ($student as $examSubjectGroup) {
            //         array_push($studentList, $examSubjectGroup['id']);
            //     }
            // }
            // $examQuizItem->student_list()->sync($studentList);
        }

        // return $examQuiz;
        return $examQuizItem;
    }
}
