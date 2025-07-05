<?php

namespace Modules\GeneralEntityManagement\Intents\Religion\GetReligionListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\Religion;

class GetReligionListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getReligionListDataUserDTO = GetReligionListDataUserDTO::validate($payloadArray);

        // Action
        $religionListData = Religion::where(function (Builder $religion_query_group1) use ($getReligionListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getReligionListDataUserDTO) && $getReligionListDataUserDTO['group_filter'] != "") {
                if ($getReligionListDataUserDTO['group_filter'] == "All") {
                }
            }
        })->where(function (Builder $religion_query_group2) use ($getReligionListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getReligionListDataUserDTO) && !is_null($getReligionListDataUserDTO['search_filter_list']) && count($getReligionListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReligionListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $religion_query_group3) use ($getReligionListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getReligionListDataUserDTO) && $getReligionListDataUserDTO['search_phrase'] != "") {
                $religion_query_group3->where('name', "ILIKE", "%" . $getReligionListDataUserDTO['search_phrase'] . "%"); 

            }
        })
            ->select(
                "id",
                "name",
                "short_code",

            )
            ->orderBy("name", "asc")
            ->paginate(
                $perPage = $getReligionListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getReligionListDataUserDTO["page"]
            );
        return $religionListData;
    }
}
