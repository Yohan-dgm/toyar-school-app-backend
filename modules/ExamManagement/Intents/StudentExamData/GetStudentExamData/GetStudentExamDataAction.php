<?php

namespace Modules\ExamManagement\Intents\StudentExamData\GetStudentExamData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamQuiz;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ExamManagement\Models\StudentExamReport;
use Modules\ExamManagement\Models\StudentSubjectMark;

class GetStudentExamDataAction
{
use AsAction;

public function handle($payloadArray, $actionData)
{
$getStudentExamDataUserDTO = GetStudentExamDataUserDTO::validate($payloadArray);

$studentId = $getStudentExamDataUserDTO['student_id'];

// Get Student Exam Marks
$studentExamMarks = StudentExamMark::where('student_id', $studentId)
->where('is_active', true)
->with(['student:id,full_name_with_title,admission_number'])
->with(['student_subject_mark_list:id,student_exam_mark_id,mark_type,overall_mark,name,mark'])
->with(['exam_quiz_item.exam_quiz:id,exam_title,exam_type,exam_start_date,exam_end_date'])
->select(
'id',
'exam_quiz_item_id',
'scheduling_examination_grade_subject_id',
'student_id',
'subject_total_mark',
'subject_overall_mark_percentage',
'subject_comment',
'present_type',
'grading',
'is_mark_added'
)
->get()
->toArray();

// Get Quiz Marks (from exam_quiz table with related quiz items)
$quizMarks = ExamQuiz::whereHas('exam_quiz_item_list.student_exam_mark_list', function (Builder $query) use ($studentId) {
$query->where('student_id', $studentId);
})
->with(['exam_quiz_item_list.student_exam_mark_list' => function (Builder $query) use ($studentId) {
$query->where('student_id', $studentId)
->with(['student_subject_mark_list:id,student_exam_mark_id,mark_type,overall_mark,name,mark']);
}])
->select(
'id',
'exam_type',
'exam_title',
'exam_start_date',
'exam_end_date',
'exam_start_time',
'exam_end_time',
'description'
)
->get()
->toArray();

// Get Exam Reports
$examReports = StudentExamReport::where('student_id', $studentId)
->with(['exam_quiz:id,exam_title,exam_type'])
->with(['scheduling_examination:id'])
->with(['student_exam_report_item_list'])
->select(
'id',
'student_id',
'exam_quiz_id',
'scheduling_examination_id',
'class_teacher_comment',
'class_rank',
'student_average',
'aggregate_of_mark',
'grade_level_name',
'class_average',
'serial_number'
)
->get()
->toArray();

// Get Subject Marks (detailed breakdown)
$subjectMarks = StudentSubjectMark::whereHas('student_exam_mark', function (Builder $query) use ($studentId) {
$query->where('student_id', $studentId);
})
->with(['student_exam_mark:id,student_id,subject_total_mark,subject_overall_mark_percentage,grading'])
->select(
'id',
'student_exam_mark_id',
'mark_type',
'mark',
'overall_mark',
'name'
)
->get()
->toArray();

return GetStudentExamDataResDTO::from([
'student_exam_marks' => $studentExamMarks,
'quiz_marks' => $quizMarks,
'exam_reports' => $examReports,
'subject_marks' => $subjectMarks,
]);
}
}