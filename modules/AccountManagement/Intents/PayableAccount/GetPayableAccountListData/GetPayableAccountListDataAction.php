<?php

namespace Modules\AccountManagement\Intents\PayableAccount\GetPayableAccountListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PayableAccount;

class GetPayableAccountListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getPayableAccountListDataUserDTO = GetPayableAccountListDataUserDTO::validate($payloadArray);

        // Action
        $getPayableAccountListData = PayableAccount::where(function (Builder $payable_account_query_category1) use ($getPayableAccountListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getPayableAccountListDataUserDTO) && $getPayableAccountListDataUserDTO['group_filter'] != '') {
                if ($getPayableAccountListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $payable_account_query_category2) use ($getPayableAccountListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getPayableAccountListDataUserDTO) && ! is_null($getPayableAccountListDataUserDTO['search_filter_list']) && count($getPayableAccountListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPayableAccountListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $payable_account_query_category3) use ($getPayableAccountListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getPayableAccountListDataUserDTO) && $getPayableAccountListDataUserDTO['search_phrase'] != '') {
                $payable_account_query_category3->where('name', 'ILIKE', '%'.$getPayableAccountListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getPayableAccountListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getPayableAccountListDataUserDTO['page']
            );

        return $getPayableAccountListData;
    }
}
