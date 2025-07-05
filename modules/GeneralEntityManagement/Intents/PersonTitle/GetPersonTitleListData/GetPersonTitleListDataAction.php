<?php

namespace Modules\GeneralEntityManagement\Intents\PersonTitle\GetPersonTitleListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class GetPersonTitleListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getPersonTitleListDataUserDTO = GetPersonTitleListDataUserDTO::validate($payloadArray);

        // Action
        $personTitleListData = PersonTitle::where(function (Builder $person_title_query_group1) use ($getPersonTitleListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getPersonTitleListDataUserDTO) && $getPersonTitleListDataUserDTO['group_filter'] != "") {
                if ($getPersonTitleListDataUserDTO['group_filter'] == "All") {
                }
            }
        })->where(function (Builder $person_title_query_group2) use ($getPersonTitleListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getPersonTitleListDataUserDTO) && !is_null($getPersonTitleListDataUserDTO['search_filter_list']) && count($getPersonTitleListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPersonTitleListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $person_title_query_group3) use ($getPersonTitleListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getPersonTitleListDataUserDTO) && $getPersonTitleListDataUserDTO['search_phrase'] != "") {
                $person_title_query_group3->where('name', "ILIKE", "%" . $getPersonTitleListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                "id",
                "name",
            )
            ->orderBy("sequential_order", "asc")
            ->paginate(
                $perPage = $getPersonTitleListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getPersonTitleListDataUserDTO["page"]
            );
        return $personTitleListData;
    }
}
