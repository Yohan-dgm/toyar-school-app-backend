<?php

namespace Modules\EducatorManagement\Intents\EducatorGrade\GetEducatorGradeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\EducatorGrade;

class GetEducatorGradeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // EducatorGrade Data Validation
        $getEducatorGradeListDataUserDTO = GetEducatorGradeListDataUserDTO::validate($payloadArray);

        // Action
        $educatorGradeListData = EducatorGrade::where(function (Builder $educatorGrade_query_group1) use ($getEducatorGradeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getEducatorGradeListDataUserDTO) && $getEducatorGradeListDataUserDTO['group_filter'] != '') {
                if ($getEducatorGradeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $educatorGrade_query_group2) use ($getEducatorGradeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getEducatorGradeListDataUserDTO) && ! is_null($getEducatorGradeListDataUserDTO['search_filter_list']) && count($getEducatorGradeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEducatorGradeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $educatorGrade_query_group3) use ($getEducatorGradeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getEducatorGradeListDataUserDTO) && $getEducatorGradeListDataUserDTO['search_phrase'] != '') {
                $educatorGrade_query_group3->where('name', 'ILIKE', '%'.$getEducatorGradeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getEducatorGradeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEducatorGradeListDataUserDTO['page']
            );

        return $educatorGradeListData;
    }
}
