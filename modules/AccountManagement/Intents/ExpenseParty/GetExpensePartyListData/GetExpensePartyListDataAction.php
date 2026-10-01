<?php

namespace Modules\AccountManagement\Intents\ExpenseParty\GetExpensePartyListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseParty;

class GetExpensePartyListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ExpenseParty Data Validation
        $getExpensePartyListDataUserDTO = GetExpensePartyListDataUserDTO::validate($payloadArray);

        // Action
        $expense_partyListData = ExpenseParty::where(function (Builder $expense_party_query_group1) use ($getExpensePartyListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExpensePartyListDataUserDTO) && $getExpensePartyListDataUserDTO['group_filter'] != '') {
                if ($getExpensePartyListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $expense_party_query_group2) use ($getExpensePartyListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExpensePartyListDataUserDTO) && ! is_null($getExpensePartyListDataUserDTO['search_filter_list']) && count($getExpensePartyListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExpensePartyListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $expense_party_query_group3) use ($getExpensePartyListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExpensePartyListDataUserDTO) && $getExpensePartyListDataUserDTO['search_phrase'] != '') {
                $expense_party_query_group3->where('name', 'ILIKE', '%'.$getExpensePartyListDataUserDTO['search_phrase'].'%');
                $expense_party_query_group3->orWhere('serial_number', 'ILIKE', '%'.$getExpensePartyListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['person_title' => function (Builder $person_title_query) {
                //
                $person_title_query->select('id', 'name');
            }])
            ->with(['country' => function (Builder $country_query) {
                //
                $country_query->select('id', 'name');
            }])
            ->select(
                'id',
                'serial_number',
                'expense_party_type',
                'name',
                'person_title_id',
                'name_with_title',
                'phone',
                'email',
                'full_address',
                'country_id',
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getExpensePartyListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExpensePartyListDataUserDTO['page']
            );

        return $expense_partyListData;
    }
}
