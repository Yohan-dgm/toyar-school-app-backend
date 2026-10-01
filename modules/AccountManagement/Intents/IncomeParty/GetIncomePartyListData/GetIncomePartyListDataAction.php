<?php

namespace Modules\AccountManagement\Intents\IncomeParty\GetIncomePartyListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeParty;

class GetIncomePartyListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // IncomeParty Data Validation
        $getIncomePartyListDataUserDTO = GetIncomePartyListDataUserDTO::validate($payloadArray);

        // Action
        $income_partyListData = IncomeParty::where(function (Builder $income_party_query_group1) use ($getIncomePartyListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getIncomePartyListDataUserDTO) && $getIncomePartyListDataUserDTO['group_filter'] != '') {
                if ($getIncomePartyListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $income_party_query_group2) use ($getIncomePartyListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getIncomePartyListDataUserDTO) && ! is_null($getIncomePartyListDataUserDTO['search_filter_list']) && count($getIncomePartyListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getIncomePartyListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $income_party_query_group3) use ($getIncomePartyListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getIncomePartyListDataUserDTO) && $getIncomePartyListDataUserDTO['search_phrase'] != '') {
                $income_party_query_group3->where('name', 'ILIKE', '%'.$getIncomePartyListDataUserDTO['search_phrase'].'%');
                $income_party_query_group3->orWhere('serial_number', 'ILIKE', '%'.$getIncomePartyListDataUserDTO['search_phrase'].'%');
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
                'income_party_type',
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
                $perPage = $getIncomePartyListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getIncomePartyListDataUserDTO['page']
            );

        return $income_partyListData;
    }
}
