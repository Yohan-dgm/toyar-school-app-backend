<?php

namespace Modules\GeneralEntityManagement\Intents\Country\GetCountryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\Country;

class GetCountryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getCountryListDataUserDTO = GetCountryListDataUserDTO::validate($payloadArray);

        // Action
        $countryListData = Country::where(function (Builder $country_query_group1) use ($getCountryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getCountryListDataUserDTO) && $getCountryListDataUserDTO['group_filter'] != "") {
                if ($getCountryListDataUserDTO['group_filter'] == "All") {
                }
            }
        })->where(function (Builder $country_query_group2) use ($getCountryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getCountryListDataUserDTO) && !is_null($getCountryListDataUserDTO['search_filter_list']) && count($getCountryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getCountryListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $country_query_group3) use ($getCountryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getCountryListDataUserDTO) && $getCountryListDataUserDTO['search_phrase'] != "") {
                $country_query_group3->where('name', "ILIKE", "%" . $getCountryListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                "id",
                "name",
            )
            ->orderBy("name", "asc")
            ->paginate(
                $perPage = $getCountryListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCountryListDataUserDTO["page"]
            );
        return $countryListData;
    }
}
