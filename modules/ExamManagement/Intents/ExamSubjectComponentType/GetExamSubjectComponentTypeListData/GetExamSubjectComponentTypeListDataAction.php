<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponentType\GetExamSubjectComponentTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectComponentType;

class GetExamSubjectComponentTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamSubjectComponentTypeListDataUserDTO = GetExamSubjectComponentTypeListDataUserDTO::validate($payloadArray);

        // Action
        $getExamSubjectComponentTypeListData = ExamSubjectComponentType::where(function (Builder $exam_subject_component_query_group1) use ($getExamSubjectComponentTypeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamSubjectComponentTypeListDataUserDTO) && $getExamSubjectComponentTypeListDataUserDTO['group_filter'] != '') {
                if ($getExamSubjectComponentTypeListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $exam_subject_component_query_group2) use ($getExamSubjectComponentTypeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExamSubjectComponentTypeListDataUserDTO) && ! is_null($getExamSubjectComponentTypeListDataUserDTO['search_filter_list']) && count($getExamSubjectComponentTypeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExamSubjectComponentTypeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_subject_component_query_group3) use ($getExamSubjectComponentTypeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamSubjectComponentTypeListDataUserDTO) && $getExamSubjectComponentTypeListDataUserDTO['search_phrase'] != '') {
                $exam_subject_component_query_group3->where('name', 'ILIKE', '%'.$getExamSubjectComponentTypeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamSubjectComponentTypeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamSubjectComponentTypeListDataUserDTO['page']
            );

        return $getExamSubjectComponentTypeListData;
    }
}
