<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\GetExpenseCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseCategory;

class GetExpenseCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ExpenseCategory Data Validation
        $getExpenseCategoryListDataUserDTO = GetExpenseCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $expenseCategoryListData = ExpenseCategory::where(function (Builder $expense_category_query_group1) use ($getExpenseCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExpenseCategoryListDataUserDTO) && $getExpenseCategoryListDataUserDTO['group_filter'] != '') {
                if ($getExpenseCategoryListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getExpenseCategoryListDataUserDTO['group_filter'] == 'Material Items') {
                    $expense_category_query_group1->whereHas('expense_type', function (Builder $expense_type_query) use ($getExpenseCategoryListDataUserDTO) {
                        return $expense_type_query->where('name', '=', $getExpenseCategoryListDataUserDTO['group_filter']);
                    });
                } else {
                    $expense_category_query_group1->whereHas('expense_type', function (Builder $expense_type_query) use ($getExpenseCategoryListDataUserDTO) {
                        return $expense_type_query->where('name', '=', $getExpenseCategoryListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $expense_category_query_group2) use ($getExpenseCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExpenseCategoryListDataUserDTO) && ! is_null($getExpenseCategoryListDataUserDTO['search_filter_list']) && count($getExpenseCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExpenseCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'expense_type_id' && $value != null) {
                        $expense_category_query_group2->where('expense_type_id', '=', $value);
                    }
                }
            }
        })->where(function (Builder $expense_category_query_group3) use ($getExpenseCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExpenseCategoryListDataUserDTO) && $getExpenseCategoryListDataUserDTO['search_phrase'] != '') {
                $expense_category_query_group3->where('name', 'ILIKE', '%'.$getExpenseCategoryListDataUserDTO['search_phrase'].'%');

                $expense_category_query_group3->orWhereHas('expense_type', function (Builder $expense_type_query) use ($getExpenseCategoryListDataUserDTO) {
                    return $expense_type_query->where('name', 'ILIKE', '%'.$getExpenseCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['expense_type' => function (Builder $expense_type_query) {
                //
                $expense_type_query->select('id', 'name');
            }])
            ->select(
                'id',
                'name',
                'expense_type_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getExpenseCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExpenseCategoryListDataUserDTO['page']
            );

        return $expenseCategoryListData;
    }
}
