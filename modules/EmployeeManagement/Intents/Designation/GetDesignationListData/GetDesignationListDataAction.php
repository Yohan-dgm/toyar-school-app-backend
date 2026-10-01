<?php

namespace Modules\EmployeeManagement\Intents\Designation\GetDesignationListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EmployeeManagement\Models\Designation;

class GetDesignationListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Designation Data Validation
        $getDesignationListDataUserDTO = GetDesignationListDataUserDTO::validate($payloadArray);

        // Action
        $designationListData = Designation::where(function (Builder $designation_query_group1) use ($getDesignationListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getDesignationListDataUserDTO) && $getDesignationListDataUserDTO['group_filter'] != '') {
                if ($getDesignationListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $designation_query_group2) use ($getDesignationListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getDesignationListDataUserDTO) && ! is_null($getDesignationListDataUserDTO['search_filter_list']) && count($getDesignationListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getDesignationListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $designation_query_group3) use ($getDesignationListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getDesignationListDataUserDTO) && $getDesignationListDataUserDTO['search_phrase'] != '') {
                $designation_query_group3->where('name', 'ILIKE', '%'.$getDesignationListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getDesignationListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getDesignationListDataUserDTO['page']
            );

        return $designationListData;
    }
}
