<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\GetIncomeCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeCategory;

class GetIncomeCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // IncomeCategory Data Validation
        $getIncomeCategoryListDataUserDTO = GetIncomeCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $incomeCategoryListData = IncomeCategory::where(function (Builder $income_category_query_group1) use ($getIncomeCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getIncomeCategoryListDataUserDTO) && $getIncomeCategoryListDataUserDTO['group_filter'] != '') {
                if ($getIncomeCategoryListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getIncomeCategoryListDataUserDTO['group_filter'] == 'Material Items') {
                    $income_category_query_group1->whereHas('income_type', function (Builder $income_type_query) use ($getIncomeCategoryListDataUserDTO) {
                        return $income_type_query->where('name', '=', $getIncomeCategoryListDataUserDTO['group_filter']);
                    });
                } else {
                    $income_category_query_group1->whereHas('income_type', function (Builder $income_type_query) use ($getIncomeCategoryListDataUserDTO) {
                        return $income_type_query->where('name', '=', $getIncomeCategoryListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $income_category_query_group2) use ($getIncomeCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getIncomeCategoryListDataUserDTO) && ! is_null($getIncomeCategoryListDataUserDTO['search_filter_list']) && count($getIncomeCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getIncomeCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'income_type_id' && $value != null) {
                        $income_category_query_group2->where('income_type_id', '=', $value);
                    }
                }
            }
        })->where(function (Builder $income_category_query_group3) use ($getIncomeCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getIncomeCategoryListDataUserDTO) && $getIncomeCategoryListDataUserDTO['search_phrase'] != '') {
                $income_category_query_group3->where('name', 'ILIKE', '%'.$getIncomeCategoryListDataUserDTO['search_phrase'].'%');

                $income_category_query_group3->orWhereHas('income_type', function (Builder $income_type_query) use ($getIncomeCategoryListDataUserDTO) {
                    return $income_type_query->where('name', 'ILIKE', '%'.$getIncomeCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['income_type' => function (Builder $income_type_query) {
                //
                $income_type_query->select('id', 'name');
            }])
            ->select(
                'id',
                'name',
                'income_type_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getIncomeCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getIncomeCategoryListDataUserDTO['page']
            );

        return $incomeCategoryListData;
    }
}
