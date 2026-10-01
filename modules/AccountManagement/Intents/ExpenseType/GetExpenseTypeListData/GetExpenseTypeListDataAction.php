<?php

namespace Modules\AccountManagement\Intents\ExpenseType\GetExpenseTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseType;

class GetExpenseTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ExpenseType Data Validation
        $getExpenseTypeListDataUserDTO = GetExpenseTypeListDataUserDTO::validate($payloadArray);

        // Action
        $expenseTypeListData = ExpenseType::where(function (Builder $expenseType_query_group1) use ($getExpenseTypeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExpenseTypeListDataUserDTO) && $getExpenseTypeListDataUserDTO['group_filter'] != '') {
                if ($getExpenseTypeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $expenseType_query_group2) use ($getExpenseTypeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExpenseTypeListDataUserDTO) && ! is_null($getExpenseTypeListDataUserDTO['search_filter_list']) && count($getExpenseTypeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExpenseTypeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $expenseType_query_group3) use ($getExpenseTypeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExpenseTypeListDataUserDTO) && $getExpenseTypeListDataUserDTO['search_phrase'] != '') {
                $expenseType_query_group3->where('name', 'ILIKE', '%'.$getExpenseTypeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getExpenseTypeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExpenseTypeListDataUserDTO['page']
            );

        return $expenseTypeListData;
    }
}
