<?php

namespace Modules\SystemEntityManagement\Intents\GradeLevelClass\GetGradeLevelClassListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\GradeLevelClass;

class GetGradeLevelClassListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // GradeLevelClass Data Validation
        $getGradeLevelClassListDataUserDTO = GetGradeLevelClassListDataUserDTO::validate($payloadArray);

        // Action
        $gradeLevelClassListData = GradeLevelClass::where(function (Builder $gradeLevelClass_query_group1) use ($getGradeLevelClassListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getGradeLevelClassListDataUserDTO) && $getGradeLevelClassListDataUserDTO['group_filter'] != '') {
                if ($getGradeLevelClassListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $gradeLevelClass_query_group2) use ($getGradeLevelClassListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getGradeLevelClassListDataUserDTO) && ! is_null($getGradeLevelClassListDataUserDTO['search_filter_list']) && count($getGradeLevelClassListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getGradeLevelClassListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $gradeLevelClass_query_group3) use ($getGradeLevelClassListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getGradeLevelClassListDataUserDTO) && $getGradeLevelClassListDataUserDTO['search_phrase'] != '') {
                $gradeLevelClass_query_group3->where('name', 'ILIKE', '%'.$getGradeLevelClassListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getGradeLevelClassListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getGradeLevelClassListDataUserDTO['page']
            );

        return $gradeLevelClassListData;
    }
}
