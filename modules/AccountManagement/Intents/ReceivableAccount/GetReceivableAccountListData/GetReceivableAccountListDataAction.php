<?php

namespace Modules\AccountManagement\Intents\ReceivableAccount\GetReceivableAccountListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceivableAccount;

class GetReceivableAccountListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getReceivableAccountListDataUserDTO = GetReceivableAccountListDataUserDTO::validate($payloadArray);

        // Action
        $getReceivableAccountListData = ReceivableAccount::where(function (Builder $receivable_account_query_category1) use ($getReceivableAccountListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getReceivableAccountListDataUserDTO) && $getReceivableAccountListDataUserDTO['group_filter'] != '') {
                if ($getReceivableAccountListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $receivable_account_query_category2) use ($getReceivableAccountListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getReceivableAccountListDataUserDTO) && ! is_null($getReceivableAccountListDataUserDTO['search_filter_list']) && count($getReceivableAccountListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableAccountListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $receivable_account_query_category3) use ($getReceivableAccountListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getReceivableAccountListDataUserDTO) && $getReceivableAccountListDataUserDTO['search_phrase'] != '') {
                $receivable_account_query_category3->where('name', 'ILIKE', '%'.$getReceivableAccountListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getReceivableAccountListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getReceivableAccountListDataUserDTO['page']
            );

        return $getReceivableAccountListData;
    }
}
