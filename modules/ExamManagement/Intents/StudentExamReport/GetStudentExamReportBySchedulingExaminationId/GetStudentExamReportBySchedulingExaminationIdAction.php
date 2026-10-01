<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportBySchedulingExaminationId;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\StudentExamReport;

class GetStudentExamReportBySchedulingExaminationIdAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getStudentExamReportBySchedulingExaminationIdUserDTO = GetStudentExamReportBySchedulingExaminationIdUserDTO::validate($payloadArray);

        $studentExamReports = StudentExamReport::where('student_id', $getStudentExamReportBySchedulingExaminationIdUserDTO['student_id'])
            ->where('id', '>=', 193)
            ->with(['scheduling_examination' => function (Builder $scheduling_examination_query) {
                $scheduling_examination_query->select('id', 'exam_type', 'exam_title', 'exam_start_date', 'exam_end_date');
            }])
            ->with(['student' => function (Builder $student_query) {
                $student_query->with(['student_attachment_list' => function (Builder $student_attachment_list_query) {
                    $student_attachment_list_query->select('id', 'student_id', 'file_name', 'original_file_name', 'mime_type');
                }])->with(['grade_level' => function (Builder $grade_level_query) {
                    $grade_level_query->select('id', 'name');
                }]);
                $student_query->select('id', 'full_name_with_title', 'admission_number', 'grade_level_id');
            }])
            ->with(['student_exam_report_item_list' => function (Builder $student_exam_report_item_list_query) {
                $student_exam_report_item_list_query->with(['subject' => function (Builder $subject_query) {
                    $subject_query->select('id', 'name');
                }]);
                $student_exam_report_item_list_query->select(
                    'id',
                    'student_exam_report_id',
                    'subject_id',
                    'subject_name',
                    'subject_mark',
                    'grading',
                    'subject_overall_mark_percentage',
                    'present_type',
                    'subject_remark',
                    'subject_position'
                );
            }])
            ->select(
                'id',
                'student_id',
                'scheduling_examination_id',
                'class_teacher_comment',
                'class_rank',
                'student_average',
                'aggregate_of_mark',
                'grade_level_name',
                'grade_level_class_id',
                'serial_number'
            )
            ->orderBy('id', 'DESC')
            ->get();

        if ($studentExamReports->isEmpty()) {
            return [
                'student_info' => null,
                'exam_reports' => [],
            ];
        }

        // Get student info from first report (same across all reports)
        $firstReport = $studentExamReports->first();
        $studentInfo = (object) [
            'student_id' => $firstReport->student->id ?? null,
            'full_name_with_title' => $firstReport->student->full_name_with_title ?? null,
            'admission_number' => $firstReport->student->admission_number ?? null,
            'grade_level_name' => $firstReport->student->grade_level->name ?? $firstReport->grade_level_name ?? null,
            'student_attachments' => $firstReport->student->student_attachment_list ?? [],
        ];

        // Build array of exam reports
        $examReports = [];
        foreach ($studentExamReports as $report) {
            $examDetails = (object) [
                'exam_title' => $report->scheduling_examination->exam_title ?? null,
                'exam_type' => $report->scheduling_examination->exam_type ?? null,
                'exam_start_date' => $report->scheduling_examination->exam_start_date ?? null,
                'exam_end_date' => $report->scheduling_examination->exam_end_date ?? null,
            ];

            $reportSummary = (object) [
                'class_teacher_comment' => $report->class_teacher_comment,
                'class_rank' => $report->class_rank,
                'student_average' => $report->student_average,
                'aggregate_of_mark' => $report->aggregate_of_mark,
                'grade_level_class_id' => $report->grade_level_class_id,
                'serial_number' => $report->serial_number,
            ];

            $subjectDetails = [];
            foreach ($report->student_exam_report_item_list as $item) {
                $subjectDetails[] = [
                    'subject_id' => $item->subject_id,
                    'subject_name' => $item->subject->name ?? $item->subject_name,
                    'subject_mark' => $item->subject_mark,
                    'grading' => $item->grading,
                    'subject_overall_mark_percentage' => $item->subject_overall_mark_percentage,
                    'present_type' => $item->present_type,
                    'subject_position' => $item->subject_position,
                    'subject_remark' => $item->subject_remark,
                ];
            }

            $examReports[] = [
                'scheduling_examination_id' => $report->scheduling_examination_id,
                'grade_level_name' => $report->grade_level_name,
                'exam_details' => $examDetails,
                'report_summary' => $reportSummary,
                'subject_details' => $subjectDetails,
            ];
        }

        return [
            'student_info' => $studentInfo,
            'exam_reports' => $examReports,
        ];
    }
}
