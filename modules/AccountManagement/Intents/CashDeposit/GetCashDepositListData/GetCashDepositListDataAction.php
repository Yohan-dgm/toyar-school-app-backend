<?php

namespace Modules\AccountManagement\Intents\CashDeposit\GetCashDepositListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\CashDeposit;

class GetCashDepositListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // CashDeposit Data Validation
        $getCashDepositListDataUserDTO = GetCashDepositListDataUserDTO::validate($payloadArray);

        // Action
        $cash_deposit = CashDeposit::where(function (Builder $cash_deposit_group1) use ($getCashDepositListDataUserDTO) {
            // Handle group_filter
            if (! empty($getCashDepositListDataUserDTO['group_filter']) && $getCashDepositListDataUserDTO['group_filter'] === 'All') {
            }
            if (! empty($getCashDepositListDataUserDTO['group_filter']) && $getCashDepositListDataUserDTO['group_filter'] === 'Pending Attachment') {
                $cash_deposit_group1->where('is_attached', false);
            }
        })->where(function (Builder $cash_deposit_group2) use ($getCashDepositListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getCashDepositListDataUserDTO['search_filter_list'])) {
                foreach ($getCashDepositListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $cash_deposit_group3) use ($getCashDepositListDataUserDTO) {
            // Handle search_phrase

            if (array_key_exists('search_phrase', $getCashDepositListDataUserDTO) && $getCashDepositListDataUserDTO['search_phrase'] != '') {

                $cash_deposit_group3->orWhere('serial_number', 'ILIKE', '%'.$getCashDepositListDataUserDTO['search_phrase'].'%');
                $cash_deposit_group3->orWhere('cash_deposit_date', 'ILIKE', '%'.$getCashDepositListDataUserDTO['search_phrase'].'%');
                $cash_deposit_group3->orWhere('total_amount', 'ILIKE', '%'.$getCashDepositListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['bank_account' => function (Builder $bank_account_query) {
                //
                $bank_account_query->select('id', 'name');
            }])
            ->with(['receipt_voucher' => function (Builder $cash_deposit_item_list_query) {
                //
                $cash_deposit_item_list_query->select('id', 'cash_deposit_id', 'amount', 'receipt_voucher_id');
                $cash_deposit_item_list_query->with(['receipt_voucher' => function (Builder $receipt_voucher_query) {
                    //
                    $receipt_voucher_query->select('id', 'serial_number');
                }]);
            }])

            ->select(
                'id',
                'cash_deposit_date',
                'bank_account_id',
                'total_amount',
                'received_by',
                'created_at',
                'serial_number',
                'is_attached'
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getCashDepositListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCashDepositListDataUserDTO['page']
            );

        return $cash_deposit;
    }
}
