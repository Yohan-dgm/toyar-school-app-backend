<?php

namespace Modules\AccountManagement\Intents\IncomeType\GetIncomeTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeType;

class GetIncomeTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // IncomeType Data Validation
        $getIncomeTypeListDataUserDTO = GetIncomeTypeListDataUserDTO::validate($payloadArray);

        // Action
        $incomeTypeListData = IncomeType::where(function (Builder $incomeType_query_group1) use ($getIncomeTypeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getIncomeTypeListDataUserDTO) && $getIncomeTypeListDataUserDTO['group_filter'] != '') {
                if ($getIncomeTypeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $incomeType_query_group2) use ($getIncomeTypeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getIncomeTypeListDataUserDTO) && ! is_null($getIncomeTypeListDataUserDTO['search_filter_list']) && count($getIncomeTypeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getIncomeTypeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $incomeType_query_group3) use ($getIncomeTypeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getIncomeTypeListDataUserDTO) && $getIncomeTypeListDataUserDTO['search_phrase'] != '') {
                $incomeType_query_group3->where('name', 'ILIKE', '%'.$getIncomeTypeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getIncomeTypeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getIncomeTypeListDataUserDTO['page']
            );

        return $incomeTypeListData;
    }
}
