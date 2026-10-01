<?php

namespace Modules\StudentManagement\Intents\SchoolHouse\GetSchoolHouseListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\SchoolHouse;

class GetSchoolHouseListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // SchoolHouse Data Validation
        $getSchoolHouseListDataUserDTO = GetSchoolHouseListDataUserDTO::validate($payloadArray);

        // Action
        $schoolHouseListData = SchoolHouse::where(function (Builder $school_house_query_group1) use ($getSchoolHouseListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSchoolHouseListDataUserDTO) && $getSchoolHouseListDataUserDTO['group_filter'] != '') {
                if ($getSchoolHouseListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $school_house_query_group2) use ($getSchoolHouseListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSchoolHouseListDataUserDTO) && ! is_null($getSchoolHouseListDataUserDTO['search_filter_list']) && count($getSchoolHouseListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSchoolHouseListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $school_house_query_group3) use ($getSchoolHouseListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSchoolHouseListDataUserDTO) && $getSchoolHouseListDataUserDTO['search_phrase'] != '') {
                $school_house_query_group3->where('name', 'ILIKE', '%'.$getSchoolHouseListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getSchoolHouseListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSchoolHouseListDataUserDTO['page']
            );

        return $schoolHouseListData;
    }
}
