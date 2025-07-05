<?php

namespace Modules\GeneralEntityManagement\Intents\Bank\GetBankListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\Bank;

class GetBankListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getBankListDataUserDTO = GetBankListDataUserDTO::validate($payloadArray);

        // Action
        $bankListData = Bank::where(function (Builder $bank_query_group1) use ($getBankListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getBankListDataUserDTO) && $getBankListDataUserDTO['group_filter'] != "") {
                if ($getBankListDataUserDTO['group_filter'] == "All") {
                }
            }
        })->where(function (Builder $bank_query_group2) use ($getBankListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getBankListDataUserDTO) && !is_null($getBankListDataUserDTO['search_filter_list']) && count($getBankListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getBankListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $bank_query_group3) use ($getBankListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getBankListDataUserDTO) && $getBankListDataUserDTO['search_phrase'] != "") {
                $bank_query_group3->where('name', "ILIKE", "%" . $getBankListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                "id",
                "name",
            )
            ->orderBy("name", "asc")
            ->paginate(
                $perPage = $getBankListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getBankListDataUserDTO["page"]
            );
        return $bankListData;
    }
}
