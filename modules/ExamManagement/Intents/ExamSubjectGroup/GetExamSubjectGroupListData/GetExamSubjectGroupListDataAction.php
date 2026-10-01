<?php

namespace Modules\ExamManagement\Intents\ExamSubjectGroup\GetExamSubjectGroupListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectGroup;

class GetExamSubjectGroupListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamSubjectGroupListDataUserDTO = GetExamSubjectGroupListDataUserDTO::validate($payloadArray);

        // Action
        $getExamSubjectGroupListData = ExamSubjectGroup::where(function (Builder $exam_subject_group_query_group1) use ($getExamSubjectGroupListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamSubjectGroupListDataUserDTO) && $getExamSubjectGroupListDataUserDTO['group_filter'] != '') {
                if ($getExamSubjectGroupListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $exam_subject_group_query_group2) use ($getExamSubjectGroupListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExamSubjectGroupListDataUserDTO) && ! is_null($getExamSubjectGroupListDataUserDTO['search_filter_list']) && count($getExamSubjectGroupListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExamSubjectGroupListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_subject_group_query_group3) use ($getExamSubjectGroupListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamSubjectGroupListDataUserDTO) && $getExamSubjectGroupListDataUserDTO['search_phrase'] != '') {
                $exam_subject_group_query_group3->where('name', 'ILIKE', '%'.$getExamSubjectGroupListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamSubjectGroupListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamSubjectGroupListDataUserDTO['page']
            );

        return $getExamSubjectGroupListData;
    }
}
