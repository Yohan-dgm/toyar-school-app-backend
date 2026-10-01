<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\StudentExamReport;

class GetStudentExamReportListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // StudentExamReport Data Validation
        $getStudentExamReportListDataUserDTO = GetStudentExamReportListDataUserDTO::validate($payloadArray);

        // Action
        $studentExamReportListData = StudentExamReport::where(function (Builder $student_exam_report_query_group1) use ($getStudentExamReportListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentExamReportListDataUserDTO) && $getStudentExamReportListDataUserDTO['group_filter'] != '') {
                if ($getStudentExamReportListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $student_exam_report_query_group1->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentExamReportListDataUserDTO) {
                        return $grade_level_class_query->where('name', '=', $getStudentExamReportListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $student_exam_report_query_group2) use ($getStudentExamReportListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentExamReportListDataUserDTO) && ! is_null($getStudentExamReportListDataUserDTO['search_filter_list']) && count($getStudentExamReportListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentExamReportListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $student_exam_report_query_group3) use ($getStudentExamReportListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentExamReportListDataUserDTO) && $getStudentExamReportListDataUserDTO['search_phrase'] != '') {
                $student_exam_report_query_group3->where('class_rank', 'ILIKE', '%'.$getStudentExamReportListDataUserDTO['search_phrase'].'%');
                $student_exam_report_query_group3->orWhere('student_average', 'ILIKE', '%'.$getStudentExamReportListDataUserDTO['search_phrase'].'%');

                $student_exam_report_query_group3->orWhereHas('student', function (Builder $student_query) use ($getStudentExamReportListDataUserDTO) {
                    return $student_query
                        ->where('full_name', 'ILIKE', '%'.$getStudentExamReportListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getStudentExamReportListDataUserDTO['search_phrase'].'%');
                });
                // $student_exam_report_query_group3->whereHas('employee', function (Builder $employee_query) use ($getStudentExamReportListDataUserDTO) {
                //     return $employee_query->where('full_name', "ILIKE", "%" . $getStudentExamReportListDataUserDTO['search_phrase'] . "%");
                // });
            }
        })
            // ->with(['employee' => function (Builder $employee_query) {
            //     //
            //     $employee_query->with(['employee_type' => function (Builder $employee_type_query) {
            //         //
            //         $employee_type_query->select("employee_type.id", "employee_type.name");
            //     }])->select("id", "full_name", "nic_number", "epf_number", "employee_type_id");
            // }])
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->with(['student_attachment_list' => function (Builder $student_attachment_list_query) {
                    //
                    $student_attachment_list_query->select('id', 'student_id', 'file_name', 'original_file_name', 'mime_type');
                }])->with(['grade_level' => function (Builder $grade_level_query) {
                    //
                    $grade_level_query->select('id', 'name');
                }]);
                $student_query->select('id', 'full_name_with_title', 'admission_number', 'grade_level_id');
            }])
            ->with(['student_exam_report_item_list' => function (Builder $student_exam_report_item_list_query) {
                //
                $student_exam_report_item_list_query->with(['subject' => function (Builder $subject_query) {
                    //
                    $subject_query->select('id', 'name');
                }]);
                $student_exam_report_item_list_query->select('id', 'student_exam_report_id', 'exam_quiz_item_id', 'subject_mark', 'subject_id', 'present_type', 'grading', 'subject_overall_mark_percentage');
            }])
            ->with(['scheduling_examination' => function (Builder $scheduling_examination_query) {
                $scheduling_examination_query->select('id', 'exam_type', 'exam_title');
            }])
            ->select(
                'id',
                'student_id',
                'exam_quiz_id',
                'class_teacher_comment',
                'scheduling_examination_id',
                'class_rank',
                'student_average',
                'aggregate_of_mark',
            )
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $getStudentExamReportListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentExamReportListDataUserDTO['page']
            );

        return $studentExamReportListData;
    }
}
