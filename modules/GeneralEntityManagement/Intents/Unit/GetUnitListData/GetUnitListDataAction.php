<?php

namespace Modules\GeneralEntityManagement\Intents\Unit\GetUnitListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\Unit;

class GetUnitListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getUnitListDataUserDTO = GetUnitListDataUserDTO::validate($payloadArray);

        // Action
        $unitListData = Unit::where(function (Builder $unit_query_group1) use ($getUnitListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getUnitListDataUserDTO) && $getUnitListDataUserDTO['group_filter'] != "") {
                if ($getUnitListDataUserDTO['group_filter'] == "All") {
                }
            }
        })->where(function (Builder $unit_query_group2) use ($getUnitListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getUnitListDataUserDTO) && !is_null($getUnitListDataUserDTO['search_filter_list']) && count($getUnitListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getUnitListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $unit_query_group3) use ($getUnitListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getUnitListDataUserDTO) && $getUnitListDataUserDTO['search_phrase'] != "") {
                $unit_query_group3->where('name', "ILIKE", "%" . $getUnitListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                "id",
                "name",
            )
            ->orderBy("name", "asc")
            ->paginate(
                $perPage = $getUnitListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getUnitListDataUserDTO["page"]
            );
        return $unitListData;
    }
}
