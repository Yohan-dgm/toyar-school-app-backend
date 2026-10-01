<?php

namespace Modules\InventoryManagement\Intents\MaterialItemCategory\GetMaterialItemCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemCategory;

class GetMaterialItemCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // MaterialItemCategory Data Validation
        $getMaterialItemCategoryListDataUserDTO = GetMaterialItemCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $materialItemCategoryListData = MaterialItemCategory::where(function (Builder $material_item_category_query_group1) use ($getMaterialItemCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getMaterialItemCategoryListDataUserDTO) && $getMaterialItemCategoryListDataUserDTO['group_filter'] != '') {
                if ($getMaterialItemCategoryListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getMaterialItemCategoryListDataUserDTO['group_filter'] == 'Material Items') {
                    $material_item_category_query_group1->whereHas('material_item_type', function (Builder $material_item_type_query) use ($getMaterialItemCategoryListDataUserDTO) {
                        return $material_item_type_query->where('name', '=', $getMaterialItemCategoryListDataUserDTO['group_filter']);
                    });
                } else {
                    $material_item_category_query_group1->whereHas('material_item_type', function (Builder $material_item_type_query) use ($getMaterialItemCategoryListDataUserDTO) {
                        return $material_item_type_query->where('name', '=', $getMaterialItemCategoryListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $material_item_category_query_group2) use ($getMaterialItemCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getMaterialItemCategoryListDataUserDTO) && ! is_null($getMaterialItemCategoryListDataUserDTO['search_filter_list']) && count($getMaterialItemCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getMaterialItemCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'material_item_type_id' && $value != null) {
                        $material_item_category_query_group2->where('material_item_type_id', '=', $value);
                    }
                }
            }
        })->where(function (Builder $material_item_category_query_group3) use ($getMaterialItemCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getMaterialItemCategoryListDataUserDTO) && $getMaterialItemCategoryListDataUserDTO['search_phrase'] != '') {
                $material_item_category_query_group3->where('name', 'ILIKE', '%'.$getMaterialItemCategoryListDataUserDTO['search_phrase'].'%');

                $material_item_category_query_group3->orWhereHas('material_item_type', function (Builder $material_item_type_query) use ($getMaterialItemCategoryListDataUserDTO) {
                    return $material_item_type_query->where('name', 'ILIKE', '%'.$getMaterialItemCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['material_item_type' => function (Builder $material_item_type_query) {
                //
                $material_item_type_query->select('id', 'name');
            }])
            ->select(
                'id',
                'name',
                'material_item_type_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getMaterialItemCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMaterialItemCategoryListDataUserDTO['page']
            );

        return $materialItemCategoryListData;
    }
}
