<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\GetReceiptVoucherListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceiptVoucher;

class GetReceiptVoucherListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getReceiptVoucherListDataUserDTO = GetReceiptVoucherListDataUserDTO::validate($payloadArray);

        // Action
        $receiptVoucherListData = ReceiptVoucher::where(function (Builder $receipt_voucher_query_group1) use ($getReceiptVoucherListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getReceiptVoucherListDataUserDTO) && $getReceiptVoucherListDataUserDTO['group_filter'] != "") {
                if ($getReceiptVoucherListDataUserDTO['group_filter'] == "All") {
                } else {
                    $receipt_voucher_query_group1->whereHas('receipt_voucher_status_type', function (Builder $receipt_voucher_status_type_query) use ($getReceiptVoucherListDataUserDTO) {
                        return $receipt_voucher_status_type_query->where('name', '=', $getReceiptVoucherListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $receipt_voucher_query_group2) use ($getReceiptVoucherListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getReceiptVoucherListDataUserDTO) && count($getReceiptVoucherListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceiptVoucherListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $receipt_voucher_query_group3) use ($getReceiptVoucherListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getReceiptVoucherListDataUserDTO) && $getReceiptVoucherListDataUserDTO['search_phrase'] != "") {
                $receipt_voucher_query_group3->where('amount', "ILIKE", "%" . $getReceiptVoucherListDataUserDTO['search_phrase'] . "%");
                $receipt_voucher_query_group3->orWhere('serial_number', "ILIKE", "%" . $getReceiptVoucherListDataUserDTO['search_phrase'] . "%");
                $receipt_voucher_query_group3->orWhereHas('student', function (Builder $student_query) use ($getReceiptVoucherListDataUserDTO) {
                    return $student_query->where('full_name', "ILIKE", "%" . $getReceiptVoucherListDataUserDTO['search_phrase'] . "%");
                });
                $receipt_voucher_query_group3->orWhereHas('applicant', function (Builder $applicant_query) use ($getReceiptVoucherListDataUserDTO) {
                    return $applicant_query->where('full_name', "ILIKE", "%" . $getReceiptVoucherListDataUserDTO['search_phrase'] . "%");
                });
            }
        })
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->select("id", "full_name");
            }])
            ->with(['applicant' => function (Builder $applicant_query) {
                //
                $applicant_query->with(['carer_profile_list' => function (Builder $carer_profile_list_query) {
                    //
                    $carer_profile_list_query->select("carer_profile.id", "carer_profile.carer_type", "carer_profile.full_name", "carer_profile.phone");
                }])->select("id", "gender", "full_name");
            }])
            ->with(['receipt_voucher_status_type' => function (Builder $receipt_voucher_status_type_query) {
                //
                $receipt_voucher_status_type_query->select("id", "name");
            }])
            ->select(
                "id",
                "serial_number",
                "receipt_party",
                "student_id",
                "applicant_id",
                "narration",
                "amount",
                "payment_method",
                "bank_account_id",
                "bank_deposit_date",
                "cash_account_id",
                "cash_received_date",
                "check_type",
                "check_bank_id",
                "check_number",
                "check_received_date",
                "check_date",
                "payment_received_by_id",
                "payment_received_date",
                "receipt_voucher_status_type_id",
            )
            ->orderBy("payment_received_date", "desc")
            ->paginate(
                $perPage = $getReceiptVoucherListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getReceiptVoucherListDataUserDTO["page"]
            );
        return $receiptVoucherListData;
    }
}
