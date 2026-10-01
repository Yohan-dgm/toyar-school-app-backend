<?php

namespace Modules\ExamManagement\Intents\ExamQuiz\GenerateExamReport;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamQuiz;
use Modules\ExamManagement\Models\ExamQuizItem;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ExamManagement\Models\StudentExamReport;
use Modules\ExamManagement\Models\StudentExamReportItem;

class GenerateExamReportAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $generateExamReportUserDTO = GenerateExamReportUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // Get Data
        $student_id_list = [];
        $examQuizItem = ExamQuizItem::where('exam_quiz_id', $generateExamReportUserDTO['id'])->get();
        if (! $examQuizItem->isEmpty()) {
            foreach ($examQuizItem as $item) {
                $studentExamMark = StudentExamMark::where('exam_quiz_item_id', $item->id)->get();
                if (! $studentExamMark->isEmpty()) {
                    foreach ($studentExamMark as $mark) {
                        $student_id_list[] = $mark->student_id;
                    }
                }
            }
        }
        // Save In Database
        $student_id_list = array_unique($student_id_list);
        $examQuiz = ExamQuiz::where('id', $generateExamReportUserDTO['id'])->first();
        if (! empty($student_id_list)) {
            foreach ($student_id_list as $student_id) {
                $examReportData = [];
                $examReportData['student_id'] = $student_id;
                $examReportData['exam_quiz_id'] = $generateExamReportUserDTO['id'];
                $studentExamMarkDate['created_by'] = $actionData['updated_by'];

                $oldStudentExamReport = StudentExamReport::where('student_id', $student_id)->where('exam_quiz_id', $generateExamReportUserDTO['id'])->first();
                if (! empty($oldStudentExamReport)) {
                    StudentExamReport::where('id', $oldStudentExamReport->id)->update($system_data);
                    $studentExamReport = $oldStudentExamReport;
                } else {
                    $studentExamReport = StudentExamReport::create($examReportData);
                }

                $studentExamMark = StudentExamMark::where(function (Builder $student_exam_mark_query) use ($student_id, $generateExamReportUserDTO) {
                    $student_exam_mark_query->whereHas('exam_quiz_item', function (Builder $exam_quiz_item_query) use ($generateExamReportUserDTO) {
                        $exam_quiz_item_query->where('exam_quiz_id', $generateExamReportUserDTO['id']);
                    });
                    $student_exam_mark_query->where('student_id', $student_id);
                })
                    ->with('exam_quiz_item')
                    ->get();

                $student_total_mark = 0;
                $subject_count = 0;
                if (! $studentExamMark->isEmpty()) {
                    foreach ($studentExamMark as $ExamMark) {
                        $studentExamMarkDate = [];
                        $studentExamMarkDate['student_exam_report_id'] = $studentExamReport->id;
                        $studentExamMarkDate['exam_quiz_item_id'] = $ExamMark->exam_quiz_item_id;
                        $studentExamMarkDate['student_exam_mark_id'] = $ExamMark->id;
                        $studentExamMarkDate['subject_mark'] = $ExamMark->subject_total_mark;
                        $studentExamMarkDate['subject_id'] = $ExamMark->exam_quiz_item->subject_id;
                        $studentExamMarkDate['updated_by'] = $actionData['updated_by'];

                        $student_total_mark += floatval($ExamMark->subject_total_mark);
                        $subject_count++;
                        $oldStudentExamReportItem = StudentExamReportItem::where('student_exam_report_id', $studentExamReport->id)->where('exam_quiz_item_id', $ExamMark->exam_quiz_item_id)->first();
                        if (! empty($oldStudentExamReportItem)) {
                            StudentExamReportItem::where('id', $oldStudentExamReportItem->id)->update($studentExamMarkDate);
                        } else {
                            StudentExamReportItem::create($studentExamMarkDate);
                        }
                    }
                }
                $examReportData['average'] = $student_total_mark / $subject_count;
                $examReportData['aggregate'] = $student_total_mark;
                StudentExamReport::where('id', $studentExamReport->id)->update($examReportData);
            }
            $uodateExamQuizData['is_generate_student_exam_report'] = true;
            ExamQuiz::where('id', $generateExamReportUserDTO['id'])->update($uodateExamQuizData);
        }

        return $examQuiz;
    }
}
