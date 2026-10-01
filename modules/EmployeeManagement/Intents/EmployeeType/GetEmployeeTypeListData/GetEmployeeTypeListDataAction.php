<?php

namespace Modules\EmployeeManagement\Intents\EmployeeType\GetEmployeeTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EmployeeManagement\Models\EmployeeType;

class GetEmployeeTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // EmployeeType Data Validation
        $getEmployeeTypeListDataUserDTO = GetEmployeeTypeListDataUserDTO::validate($payloadArray);

        // Action
        $employeeTypeListData = EmployeeType::where(function (Builder $employeeType_query_group1) use ($getEmployeeTypeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getEmployeeTypeListDataUserDTO) && $getEmployeeTypeListDataUserDTO['group_filter'] != '') {
                if ($getEmployeeTypeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $employeeType_query_group2) use ($getEmployeeTypeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getEmployeeTypeListDataUserDTO) && ! is_null($getEmployeeTypeListDataUserDTO['search_filter_list']) && count($getEmployeeTypeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEmployeeTypeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $employeeType_query_group3) use ($getEmployeeTypeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getEmployeeTypeListDataUserDTO) && $getEmployeeTypeListDataUserDTO['search_phrase'] != '') {
                $employeeType_query_group3->where('name', 'ILIKE', '%'.$getEmployeeTypeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getEmployeeTypeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEmployeeTypeListDataUserDTO['page']
            );

        return $employeeTypeListData;
    }
}
