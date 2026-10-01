<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\GetPaymentVoucherListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentVoucher;

class GetPaymentVoucherListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // PaymentVoucher Data Validation
        $getPaymentVoucherListDataUserDTO = GetPaymentVoucherListDataUserDTO::validate($payloadArray);

        // Action
        $paymentVoucherListData = PaymentVoucher::where(function (Builder $paymentVoucher_query_group1) use ($getPaymentVoucherListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getPaymentVoucherListDataUserDTO) && $getPaymentVoucherListDataUserDTO['group_filter'] != '') {
                if ($getPaymentVoucherListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $paymentVoucher_query_group2) use ($getPaymentVoucherListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getPaymentVoucherListDataUserDTO) && ! is_null($getPaymentVoucherListDataUserDTO['search_filter_list']) && count($getPaymentVoucherListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentVoucherListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $paymentVoucher_query_group3) use ($getPaymentVoucherListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getPaymentVoucherListDataUserDTO) && $getPaymentVoucherListDataUserDTO['search_phrase'] != '') {
                $paymentVoucher_query_group3->where('serial_number', 'ILIKE', '%'.$getPaymentVoucherListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'payment_voucher_type',
                'purchase_order_id',
                'expense_note_id',
                'amount',
                'narration',
                'payment_method',
                'cash_account_id',
                'cash_paid_date',
                'bank_account_id',
                'bank_transfer_date',
                'bank_transfer_reference_number',
                'check_type',
                'check_bank_account_id',
                'check_number',
                'check_issued_date',
                'check_date',
                'payment_issued_by_id',
                //
                'payment_issued_date',
                'serial_number',
                'created_by',
                'updated_by',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getPaymentVoucherListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getPaymentVoucherListDataUserDTO['page']
            );

        return $paymentVoucherListData;
    }
}
