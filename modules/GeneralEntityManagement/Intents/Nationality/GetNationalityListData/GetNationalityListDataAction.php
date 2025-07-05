<?php

namespace Modules\GeneralEntityManagement\Intents\Nationality\GetNationalityListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\Nationality;

class GetNationalityListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getNationalityListDataUserDTO = GetNationalityListDataUserDTO::validate($payloadArray);

        // Action
        $nationalityListData = Nationality::where(function (Builder $nationality_query_group1) use ($getNationalityListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getNationalityListDataUserDTO) && $getNationalityListDataUserDTO['group_filter'] != "") {
                if ($getNationalityListDataUserDTO['group_filter'] == "All") {
                }
            }
        })->where(function (Builder $nationality_query_group2) use ($getNationalityListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getNationalityListDataUserDTO) && !is_null($getNationalityListDataUserDTO['search_filter_list']) && count($getNationalityListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getNationalityListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $nationality_query_group3) use ($getNationalityListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getNationalityListDataUserDTO) && $getNationalityListDataUserDTO['search_phrase'] != "") {
                $nationality_query_group3->where('name', "ILIKE", "%" . $getNationalityListDataUserDTO['search_phrase'] . "%"); 
            }
        })
            ->select(
                "id",
                "name",
                "short_code",
            )
            ->orderBy("name", "asc")
            ->paginate(
                $perPage = $getNationalityListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getNationalityListDataUserDTO["page"]
            );
        return $nationalityListData;
    }
}
