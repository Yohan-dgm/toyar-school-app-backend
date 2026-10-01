<?php

namespace Modules\AccountManagement\Intents\ReceivableDashboard\GetReceivableDashboardListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\ReceivableDashboard;

class GetReceivableDashboardListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ReceivableDashboard Data Validation
        $getReceivableDashboardListDataUserDTO = GetReceivableDashboardListDataUserDTO::validate($payloadArray);

        // Action
        // $receivable_dashboardListData = ReceivableDashboard::where(function (Builder $receivable_dashboard_query_group1) use ($getReceivableDashboardListDataUserDTO) {
        //     // group_filter
        //     if (array_key_exists('group_filter', $getReceivableDashboardListDataUserDTO) && $getReceivableDashboardListDataUserDTO['group_filter'] != "") {
        //         if ($getReceivableDashboardListDataUserDTO['group_filter'] == "All") {
        //         } else {
        //         }
        //     }
        // })->where(function (Builder $receivable_dashboard_query_group2) use ($getReceivableDashboardListDataUserDTO) {
        //     // search_filter_list
        //     if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && !is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
        //         foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
        //         }
        //     }
        // })->where(function (Builder $receivable_dashboard_query_group3) use ($getReceivableDashboardListDataUserDTO) {
        //     // search_phrase
        //     if (array_key_exists('search_phrase', $getReceivableDashboardListDataUserDTO) && $getReceivableDashboardListDataUserDTO['search_phrase'] != "") {
        //         $receivable_dashboard_query_group3->where("name", "ILIKE", "%" . $getReceivableDashboardListDataUserDTO['search_phrase'] . "%");
        //         $receivable_dashboard_query_group3->orWhere("serial_number", "ILIKE", "%" . $getReceivableDashboardListDataUserDTO['search_phrase'] . "%");
        //     }
        // })
        //     ->with(['person_title' => function (Builder $person_title_query) {
        //         //
        //         $person_title_query->select("id", "name");
        //     }])
        //     ->with(['country' => function (Builder $country_query) {
        //         //
        //         $country_query->select("id", "name");
        //     }])
        //     ->select(
        //         "id",
        //         "serial_number",
        //         "receivable_dashboard_type",
        //         "name",
        //         "person_title_id",
        //         "name_with_title",
        //         "phone",
        //         "email",
        //         "full_address",
        //         "country_id",
        //     )
        //     ->orderBy("name", "asc");

        $admission_fee_invoice['admission_fee_invoice_count'] = AdmissionFeeInvoice::where(function (Builder $receivable_dashboard_query_group1) use ($getReceivableDashboardListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->count();

        return $admission_fee_invoice;
    }
}
