<?php

namespace Modules\ExamManagement\Intents\ExamQuiz\GetExamQuizListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamQuiz;

class GetExamQuizListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamQuizListDataUserDTO = GetExamQuizListDataUserDTO::validate($payloadArray);

        // Action
        $getExamQuizListData = ExamQuiz::where(function (Builder $exam_quiz_query_category1) use ($getExamQuizListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamQuizListDataUserDTO) && $getExamQuizListDataUserDTO['group_filter'] != '') {
                if ($getExamQuizListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $exam_quiz_query_category2) use ($getExamQuizListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExamQuizListDataUserDTO) && ! is_null($getExamQuizListDataUserDTO['search_filter_list']) && count($getExamQuizListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExamQuizListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_quiz_query_category3) use ($getExamQuizListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamQuizListDataUserDTO) && $getExamQuizListDataUserDTO['search_phrase'] != '') {
                $exam_quiz_query_category3->where('exam_type', 'ILIKE', '%'.$getExamQuizListDataUserDTO['search_phrase'].'%');
            }
            $exam_quiz_query_category3->orWhereHas('program', function (Builder $program_query) use ($getExamQuizListDataUserDTO) {
                return $program_query
                    ->where('name', 'ILIKE', '%'.$getExamQuizListDataUserDTO['search_phrase'].'%')
                    ->orWhere('program_code', 'ILIKE', '%'.$getExamQuizListDataUserDTO['search_phrase'].'%');
            });
        })
            ->with(['program' => function (Builder $program_query) {
                //
                $program_query->select('id', 'name', 'program_code');
            }])
            ->with(['exam_quiz_item_list' => function (Builder $exam_quiz_item_list_query) {
                //
                $exam_quiz_item_list_query->with(['subject' => function (Builder $subject_query) {
                    //
                    $subject_query->select('id', 'name', 'subject_code');
                }])
                    ->with(['student_list' => function (Builder $student_list_query) {
                        //
                        $student_list_query->select('exam_quiz_item_student_pivot.id as exam_quiz_item_student_pivot_id', 'exam_quiz_item_id as id', 'full_name', 'marks', 'is_absent');
                    }])
                    ->select('id', 'subject_id', 'exam_quiz_id', 'subject_start_date', 'subject_end_date', 'subject_start_time', 'subject_end_time');
            }])
            ->select(
                'id',
                'exam_type',
                'program_id',
                'exam_start_date',
                'exam_end_date',
                'exam_start_time',
                'exam_end_time',
                'exam_title',
                'description',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamQuizListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamQuizListDataUserDTO['page']
            );

        return $getExamQuizListData;
    }
}
