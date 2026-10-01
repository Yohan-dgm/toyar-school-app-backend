<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemSubCategory\GetCurrentAssetItemSubCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemSubCategory;

class GetCurrentAssetItemSubCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // CurrentAssetItemSubCategory Data Validation
        $getCurrentAssetItemSubCategoryListDataUserDTO = GetCurrentAssetItemSubCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $currentAssetItemSubCategoryListData = CurrentAssetItemSubCategory::where(function (Builder $CurrentAssetItemSubCategory_query_group1) use ($getCurrentAssetItemSubCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getCurrentAssetItemSubCategoryListDataUserDTO) && $getCurrentAssetItemSubCategoryListDataUserDTO['group_filter'] != '') {
                if ($getCurrentAssetItemSubCategoryListDataUserDTO['group_filter'] == 'All') {
                    $CurrentAssetItemSubCategory_query_group1->where('current_asset_item_category_id', $getCurrentAssetItemSubCategoryListDataUserDTO['current_asset_item_category_id']);
                }
            }
        })->where(function (Builder $CurrentAssetItemSubCategory_query_group2) use ($getCurrentAssetItemSubCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getCurrentAssetItemSubCategoryListDataUserDTO) && ! is_null($getCurrentAssetItemSubCategoryListDataUserDTO['search_filter_list']) && count($getCurrentAssetItemSubCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getCurrentAssetItemSubCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $CurrentAssetItemSubCategory_query_group3) use ($getCurrentAssetItemSubCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getCurrentAssetItemSubCategoryListDataUserDTO) && $getCurrentAssetItemSubCategoryListDataUserDTO['search_phrase'] != '') {
                $CurrentAssetItemSubCategory_query_group3->where('name', 'ILIKE', '%'.$getCurrentAssetItemSubCategoryListDataUserDTO['search_phrase'].'%');

                $CurrentAssetItemSubCategory_query_group3->orWhereHas('current_asset_item_category', function (Builder $current_asset_item_category_query) use ($getCurrentAssetItemSubCategoryListDataUserDTO) {
                    return $current_asset_item_category_query->where('name', 'ILIKE', '%'.$getCurrentAssetItemSubCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })

            ->with(['current_asset_item_category' => function (Builder $current_asset_item_category_query) {
                //
                $current_asset_item_category_query->select('id', 'name');
            }])

            ->select(
                'id',
                'name',
                'current_asset_item_category_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getCurrentAssetItemSubCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCurrentAssetItemSubCategoryListDataUserDTO['page']
            );

        return $currentAssetItemSubCategoryListData;
    }
}
