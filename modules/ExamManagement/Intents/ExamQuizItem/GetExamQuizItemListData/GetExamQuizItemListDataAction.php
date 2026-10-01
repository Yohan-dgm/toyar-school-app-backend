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
        $getExamQuizItemListData = ExamQuizItem::where(function (Builder $exam_quiz_item_query_group1) use ($getExamQuizItemListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamQuizItemListDataUserDTO) && $getExamQuizItemListDataUserDTO['group_filter'] != '') {
                if ($getExamQuizItemListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $exam_quiz_item_query_group2) {
            // search_filter_list
        })->where(function (Builder $exam_quiz_item_query_group3) use ($getExamQuizItemListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamQuizItemListDataUserDTO) && $getExamQuizItemListDataUserDTO['search_phrase'] != '') {
                $exam_quiz_item_query_group3->whereHas('subject', function (Builder $subject_query) use ($getExamQuizItemListDataUserDTO) {
                    return $subject_query
                        ->where('name', 'ILIKE', '%'.$getExamQuizItemListDataUserDTO['search_phrase'].'%')
                        ->orWhere('subject_code', 'ILIKE', '%'.$getExamQuizItemListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where(function (Builder $exam_quiz_item_query_group4) {
            // exam_quiz_id
            // if (array_key_exists('exam_quiz_id', $getExamQuizItemListDataUserDTO) && $getExamQuizItemListDataUserDTO['exam_quiz_id'] != "") {
            //     $exam_quiz_item_query_group4->where('exam_quiz_id', $getExamQuizItemListDataUserDTO['exam_quiz_id']);
            // }
        })
            // ->where(function (Builder $exam_quiz_item_query_group5) use ($getExamQuizItemListDataUserDTO) {
            //     $exam_quiz_item_query_group5->whereHas('subject_list', function (Builder $subject_query) use ($getExamQuizItemListDataUserDTO) {
            //         //
            //         $subject_query->whereHas('subjectsubject_list', function (Builder $subject_query) use ($getExamQuizItemListDataUserDTO) {
            //             //
            //             $subject_query->where('subject_id', $getExamQuizItemListDataUserDTO['subject_id']);
            //         });
            //     });
            // })
            ->with(['subject' => function (Builder $subject_query) {
                //
                $subject_query->select('id', 'name', 'subject_code');
            }])
            // ->with(['exam_quiz' => function (Builder $exam_quiz_query) {
            //     //
            //     $exam_quiz_query->select("id", "exam_type", "exam_title");
            // }])
            ->select(
                'id',
                'exam_quiz_id',
                'subject_id',
            )
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
