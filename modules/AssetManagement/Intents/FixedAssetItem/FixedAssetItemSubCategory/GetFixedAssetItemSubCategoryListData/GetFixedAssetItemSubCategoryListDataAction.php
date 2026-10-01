<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemSubCategory\GetFixedAssetItemSubCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemSubCategory;

class GetFixedAssetItemSubCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // FixedAssetItemSubCategory Data Validation
        $getFixedAssetItemSubCategoryListDataUserDTO = GetFixedAssetItemSubCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $fixedAssetItemSubCategoryListData = FixedAssetItemSubCategory::where(function (Builder $FixedAssetItemSubCategory_query_group1) use ($getFixedAssetItemSubCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getFixedAssetItemSubCategoryListDataUserDTO) && $getFixedAssetItemSubCategoryListDataUserDTO['group_filter'] != '') {
                if ($getFixedAssetItemSubCategoryListDataUserDTO['group_filter'] == 'All') {
                    $FixedAssetItemSubCategory_query_group1->where('fixed_asset_item_category_id', $getFixedAssetItemSubCategoryListDataUserDTO['fixed_asset_item_category_id']);
                }
            }
        })->where(function (Builder $FixedAssetItemSubCategory_query_group2) use ($getFixedAssetItemSubCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getFixedAssetItemSubCategoryListDataUserDTO) && ! is_null($getFixedAssetItemSubCategoryListDataUserDTO['search_filter_list']) && count($getFixedAssetItemSubCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getFixedAssetItemSubCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $FixedAssetItemSubCategory_query_group3) use ($getFixedAssetItemSubCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getFixedAssetItemSubCategoryListDataUserDTO) && $getFixedAssetItemSubCategoryListDataUserDTO['search_phrase'] != '') {
                $FixedAssetItemSubCategory_query_group3->where('name', 'ILIKE', '%'.$getFixedAssetItemSubCategoryListDataUserDTO['search_phrase'].'%');

                $FixedAssetItemSubCategory_query_group3->orWhereHas('fixed_asset_item_category', function (Builder $fixed_asset_item_category_query) use ($getFixedAssetItemSubCategoryListDataUserDTO) {
                    return $fixed_asset_item_category_query->where('name', 'ILIKE', '%'.$getFixedAssetItemSubCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })

            ->with(['fixed_asset_item_category' => function (Builder $fixed_asset_item_category_query) {
                //
                $fixed_asset_item_category_query->select('id', 'name');
            }])

            ->select(
                'id',
                'name',
                'fixed_asset_item_category_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getFixedAssetItemSubCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getFixedAssetItemSubCategoryListDataUserDTO['page']
            );

        return $fixedAssetItemSubCategoryListData;
    }
}
