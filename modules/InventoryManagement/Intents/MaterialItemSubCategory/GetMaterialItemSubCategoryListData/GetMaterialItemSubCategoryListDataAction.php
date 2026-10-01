<?php

namespace Modules\InventoryManagement\Intents\MaterialItemSubCategory\GetMaterialItemSubCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemSubCategory;

class GetMaterialItemSubCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // MaterialItemSubCategory Data Validation
        $getMaterialItemSubCategoryListDataUserDTO = GetMaterialItemSubCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $materialItemSubCategoryListData = MaterialItemSubCategory::where(function (Builder $MaterialItemSubCategory_query_group1) use ($getMaterialItemSubCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getMaterialItemSubCategoryListDataUserDTO) && $getMaterialItemSubCategoryListDataUserDTO['group_filter'] != '') {
                if ($getMaterialItemSubCategoryListDataUserDTO['group_filter'] == 'All') {
                    $MaterialItemSubCategory_query_group1->where('material_item_category_id', $getMaterialItemSubCategoryListDataUserDTO['material_item_category_id']);
                }
            }
        })->where(function (Builder $MaterialItemSubCategory_query_group2) use ($getMaterialItemSubCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getMaterialItemSubCategoryListDataUserDTO) && ! is_null($getMaterialItemSubCategoryListDataUserDTO['search_filter_list']) && count($getMaterialItemSubCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getMaterialItemSubCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $MaterialItemSubCategory_query_group3) use ($getMaterialItemSubCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getMaterialItemSubCategoryListDataUserDTO) && $getMaterialItemSubCategoryListDataUserDTO['search_phrase'] != '') {
                $MaterialItemSubCategory_query_group3->where('name', 'ILIKE', '%'.$getMaterialItemSubCategoryListDataUserDTO['search_phrase'].'%');

                $MaterialItemSubCategory_query_group3->orWhereHas('material_item_category', function (Builder $material_item_category_query) use ($getMaterialItemSubCategoryListDataUserDTO) {
                    return $material_item_category_query->where('name', 'ILIKE', '%'.$getMaterialItemSubCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })

            ->with(['material_item_category' => function (Builder $material_item_category_query) {
                //
                $material_item_category_query->select('id', 'name');
            }])

            ->select(
                'id',
                'name',
                'material_item_category_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getMaterialItemSubCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMaterialItemSubCategoryListDataUserDTO['page']
            );

        return $materialItemSubCategoryListData;
    }
}
