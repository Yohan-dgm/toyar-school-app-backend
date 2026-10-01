<?php

namespace Modules\EmployeeManagement\Intents\Employee\GetEmployeeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EmployeeManagement\Models\Employee;

class GetEmployeeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Employee Data Validation
        $getEmployeeListDataUserDTO = GetEmployeeListDataUserDTO::validate($payloadArray);

        // Action
        $employeeListData = Employee::where(function (Builder $employee_query_group1) use ($getEmployeeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getEmployeeListDataUserDTO) && $getEmployeeListDataUserDTO['group_filter'] != '') {
                if ($getEmployeeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $employee_query_group2) use ($getEmployeeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getEmployeeListDataUserDTO) && ! is_null($getEmployeeListDataUserDTO['search_filter_list']) && count($getEmployeeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEmployeeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $employee_query_group3) use ($getEmployeeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getEmployeeListDataUserDTO) && $getEmployeeListDataUserDTO['search_phrase'] != '') {
                $employee_query_group3->where('full_name', 'ILIKE', '%'.$getEmployeeListDataUserDTO['search_phrase'].'%');
                $employee_query_group3->orWhere('nic_number', 'ILIKE', '%'.$getEmployeeListDataUserDTO['search_phrase'].'%');

                $employee_query_group3->orWhereHas('employee_type', function (Builder $employee_type_query) use ($getEmployeeListDataUserDTO) {
                    return $employee_type_query->where('name', 'ILIKE', '%'.$getEmployeeListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['employee_type' => function (Builder $employee_type_query) {
                //
                $employee_type_query->select('id', 'name');
            }])
            ->select(
                'id',
                'full_name',
                'nic_number',
                'employee_type_id',
                'remaining_annual_leaves',
                'remaining_medical_leaves',
                'remaining_maternity_leaves',
            )
            ->orderBy('full_name', 'asc')
            ->paginate(
                $perPage = $getEmployeeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEmployeeListDataUserDTO['page']
            );

        return $employeeListData;
    }
}
