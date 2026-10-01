<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\GetStudentExamMarkListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\StudentExamMark;

class GetStudentExamMarkListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getStudentExamMarkListDataUserDTO = GetStudentExamMarkListDataUserDTO::validate($payloadArray);

        // Action
        $getStudentExamMarkListData = StudentExamMark::where(function (Builder $student_exam_mark_query_group1) use ($getStudentExamMarkListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentExamMarkListDataUserDTO) && $getStudentExamMarkListDataUserDTO['group_filter'] != '') {
                if ($getStudentExamMarkListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getStudentExamMarkListDataUserDTO['group_filter'] == 'Mark Pending') {
                    $student_exam_mark_query_group1->where('is_mark_added', false);
                } elseif ($getStudentExamMarkListDataUserDTO['group_filter'] == 'Mark Completed') {
                    $student_exam_mark_query_group1->where('is_mark_added', true);
                }
            }
        })->where(function (Builder $student_exam_mark_query_group2) {
            // search_filter_list
        })->where(function (Builder $student_exam_mark_query_group3) use ($getStudentExamMarkListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentExamMarkListDataUserDTO) && $getStudentExamMarkListDataUserDTO['search_phrase'] != '') {
                $student_exam_mark_query_group3->whereHas('student', function (Builder $student_query) use ($getStudentExamMarkListDataUserDTO) {
                    return $student_query
                        ->where('full_name_with_title', 'ILIKE', '%'.$getStudentExamMarkListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getStudentExamMarkListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where(function (Builder $student_exam_mark_query_group4) use ($getStudentExamMarkListDataUserDTO) {
            // exam_quiz_item_id
            if (array_key_exists('scheduling_examination_grade_subject_id', $getStudentExamMarkListDataUserDTO) && $getStudentExamMarkListDataUserDTO['scheduling_examination_grade_subject_id'] != '') {
                $student_exam_mark_query_group4->where('scheduling_examination_grade_subject_id', $getStudentExamMarkListDataUserDTO['scheduling_examination_grade_subject_id']);
            }
            // $student_exam_mark_query_group4->where('is_active', true);
        })->where('is_active', true)
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->select('id', 'full_name_with_title', 'admission_number');
            }])
            ->with(['student_subject_mark_list' => function (Builder $student_subject_mark_list_query) {
                //
                $student_subject_mark_list_query->select('id', 'student_exam_mark_id', 'mark_type', 'overall_mark', 'name', 'mark');
            }])
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
                'is_mark_added',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getStudentExamMarkListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentExamMarkListDataUserDTO['page']
            );

        return $getStudentExamMarkListData;
    }
}
