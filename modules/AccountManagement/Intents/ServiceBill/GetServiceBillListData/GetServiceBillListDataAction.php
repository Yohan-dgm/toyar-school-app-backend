<?php

namespace Modules\AccountManagement\Intents\ServiceBill\GetServiceBillListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ServiceBill;

class GetServiceBillListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ServiceBill Data Validation
        $getServiceBillListDataUserDTO = GetServiceBillListDataUserDTO::validate($payloadArray);

        // Action
        $service_bill = ServiceBill::where(function (Builder $service_bill_group1) use ($getServiceBillListDataUserDTO) {
            // Handle group_filter
            if (! empty($getServiceBillListDataUserDTO['group_filter']) && $getServiceBillListDataUserDTO['group_filter'] === 'All') {

                $service_bill_group1->whereNotNull('id');
            }
        })->where(function (Builder $service_bill_group2) use ($getServiceBillListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getServiceBillListDataUserDTO['search_filter_list'])) {
                foreach ($getServiceBillListDataUserDTO['search_filter_list'] as $key => $value) {

                }
            }
        })->where(function (Builder $service_bill_group3) use ($getServiceBillListDataUserDTO) {
            // Handle search_phrase

            if (array_key_exists('search_phrase', $getServiceBillListDataUserDTO) && $getServiceBillListDataUserDTO['search_phrase'] != '') {

                $service_bill_group3->orWhere('serial_number', 'ILIKE', '%'.$getServiceBillListDataUserDTO['search_phrase'].'%');

                $service_bill_group3->orWhereHas('student', function (Builder $student_query) use ($getServiceBillListDataUserDTO) {
                    return $student_query->where('full_name', 'ILIKE', '%'.$getServiceBillListDataUserDTO['search_phrase'].'%');
                });

                $service_bill_group3->orWhereHas('applicant', function (Builder $applicant_query) use ($getServiceBillListDataUserDTO) {
                    return $applicant_query->where('name', 'ILIKE', '%'.$getServiceBillListDataUserDTO['search_phrase'].'%');
                });

                $service_bill_group3->orWhereHas('service_bill_item_list', function (Builder $service_bill_item_list_query) use ($getServiceBillListDataUserDTO) {
                    return $service_bill_item_list_query->where('description', 'ILIKE', '%'.$getServiceBillListDataUserDTO['search_phrase'].'%');
                });

                $service_bill_group3->orWhereHas('service_bill_item_list.service_item', function (Builder $service_item_query) use ($getServiceBillListDataUserDTO) {
                    return $service_item_query->where('name', 'ILIKE', '%'.$getServiceBillListDataUserDTO['search_phrase'].'%');
                });

            }

        })
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->select('id', 'full_name');
            }])

            ->with(['applicant' => function (Builder $applicant_query) {
                //
                $applicant_query->select('id', 'name');
            }])

            ->with(['service_bill_item_list' => function (Builder $service_bill_item_list_query) {
                //
                $service_bill_item_list_query->select('service_bill_id', 'description');
            }])

            ->with(['service_bill_item_list.service_item' => function (Builder $service_item_query) {
                //
                $service_item_query->select('id', 'name');
            }])

            ->select(
                'id',
                'date',
                'bill_party',
                'student_id',
                'applicant_id',
                'total',
                'created_at',
                'serial_number'
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getServiceBillListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getServiceBillListDataUserDTO['page']
            );

        return $service_bill;
    }
}
