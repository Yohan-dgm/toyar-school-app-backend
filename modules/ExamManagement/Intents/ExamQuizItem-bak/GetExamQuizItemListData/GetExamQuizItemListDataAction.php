<?php

namespace Modules\ExamManagement\Intents\ExamQuizItem\GetExamQuizItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamQuizItem;

class GetExamQuizItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamQuizItemListDataUserDTO = GetExamQuizItemListDataUserDTO::validate($payloadArray);

        // Action
        $getExamQuizItemListData = ExamQuizItem::where(function (Builder $exam_quiz_query_category1) use ($getExamQuizItemListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamQuizItemListDataUserDTO) && $getExamQuizItemListDataUserDTO['group_filter'] != '') {
                if ($getExamQuizItemListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $exam_quiz_query_category2) use ($getExamQuizItemListDataUserDTO) {
            if (! empty($getExamQuizItemListDataUserDTO['search_filter_list'])) {
                foreach ($getExamQuizItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'exam_quiz_id' && $value != '') {
                        // var_dump($getExamQuizItemListDataUserDTO['search_filter_list']);
                        $exam_quiz_query_category2->where('exam_quiz_id', $value);
                    }
                }
            }
        })->where(function (Builder $exam_quiz_query_category3) use ($getExamQuizItemListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamQuizItemListDataUserDTO) && $getExamQuizItemListDataUserDTO['search_phrase'] != '') {
                $exam_quiz_query_category3->where('subject_start_date', 'ILIKE', '%'.$getExamQuizItemListDataUserDTO['search_phrase'].'%');
            }
            $exam_quiz_query_category3->orWhereHas('subject', function (Builder $subject_query) use ($getExamQuizItemListDataUserDTO) {
                return $subject_query
                    ->where('name', 'ILIKE', '%'.$getExamQuizItemListDataUserDTO['search_phrase'].'%')
                    ->orWhere('subject_code', 'ILIKE', '%'.$getExamQuizItemListDataUserDTO['search_phrase'].'%');
            });
        })
            ->with(['subject' => function (Builder $subject_query) {
                //
                $subject_query->select('id', 'name', 'subject_code');
            }])
            ->with(['student_list' => function (Builder $student_list_query) {
                //
                $student_list_query->select('exam_quiz_item_student_pivot.id as exam_quiz_item_student_pivot_id', 'exam_quiz_item_id as id', 'full_name', 'marks');
            }])
            ->select(
                'exam_quiz_item.id',
                'exam_quiz_item.exam_quiz_id',
                'exam_quiz_item.subject_start_date',
                'exam_quiz_item.subject_end_date',
                'exam_quiz_item.subject_start_time',
                'exam_quiz_item.subject_end_time',
                'exam_quiz_item.subject_id',
            )
            // ->leftJoin('exam_quiz_item_student_pivot', 'exam_quiz_item_student_pivot.exam_quiz_item_id', '=', 'exam_quiz_item.id')
            // ->leftJoin('student', 'student.id', '=', 'exam_quiz_item_student_pivot.student_id')
            // ->leftJoin('subject', 'exam_quiz_item.subject_id', '=', 'subject.id')
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamQuizItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamQuizItemListDataUserDTO['page']
            );

        return $getExamQuizItemListData;
    }
}
