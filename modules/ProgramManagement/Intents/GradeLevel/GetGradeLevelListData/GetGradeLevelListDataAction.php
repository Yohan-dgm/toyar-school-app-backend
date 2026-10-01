<?php

namespace Modules\ProgramManagement\Intents\GradeLevel\GetGradeLevelListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\GradeLevel;

class GetGradeLevelListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // GradeLevel Data Validation
        $getGradeLevelListDataUserDTO = GetGradeLevelListDataUserDTO::validate($payloadArray);

        // Action
        $gradeLevelListData = GradeLevel::where(function (Builder $gradeLevel_query_group1) use ($getGradeLevelListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getGradeLevelListDataUserDTO) && $getGradeLevelListDataUserDTO['group_filter'] != '') {
                if ($getGradeLevelListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $gradeLevel_query_group2) use ($getGradeLevelListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getGradeLevelListDataUserDTO) && ! is_null($getGradeLevelListDataUserDTO['search_filter_list']) && count($getGradeLevelListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getGradeLevelListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $gradeLevel_query_group3) use ($getGradeLevelListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getGradeLevelListDataUserDTO) && $getGradeLevelListDataUserDTO['search_phrase'] != '') {
                $gradeLevel_query_group3->where('name', 'ILIKE', '%'.$getGradeLevelListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['school_fee_list' => function (Builder $school_fee_list_query) {
                //
                $school_fee_list_query->select('*')->where('is_active', true);
            }])
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getGradeLevelListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getGradeLevelListDataUserDTO['page']
            );

        return $gradeLevelListData;
    }
}
