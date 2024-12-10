<?php

namespace Modules\EducatorManagement\Intents\Educator\GetEducatorListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\Educator;

class GetEducatorListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Educator Data Validation
        $getEducatorListDataUserDTO = GetEducatorListDataUserDTO::validate($payloadArray);

        // Action
        $educatorListData = Educator::where(function (Builder $educator_query_group1) use ($getEducatorListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getEducatorListDataUserDTO) && $getEducatorListDataUserDTO['group_filter'] != "") {
                if ($getEducatorListDataUserDTO['group_filter'] == "All") {
                } else {
                }
            }
        })->where(function (Builder $educator_query_group2) use ($getEducatorListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getEducatorListDataUserDTO) && count($getEducatorListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEducatorListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $educator_query_group3) use ($getEducatorListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getEducatorListDataUserDTO) && $getEducatorListDataUserDTO['search_phrase'] != "") {
                $educator_query_group3->where("full_name", "ILIKE", "%" . $getEducatorListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->with(['employee' => function (Builder $employee_query) {
                // //
                // $employee_query->select("id", "full_name", "nic_number", "epf_number");
                //
                $employee_query->with(['employee_type' => function (Builder $employee_type_query) {
                    //
                    $employee_type_query->select("employee_type.id", "employee_type.name");
                }])->select("id", "full_name", "nic_number", "epf_number", "employee_type_id");
            }])
            ->with(['educator_grade' => function (Builder $educator_grade_query) {
                //
                $educator_grade_query->select("id", "name");
            }])
            ->select(
                "id",
                "employee_id",
                "educator_grade_id",
            )
            ->orderBy("id", "desc")
            ->paginate(
                $perPage = $getEducatorListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEducatorListDataUserDTO["page"]
            );
        return $educatorListData;
    }
}
