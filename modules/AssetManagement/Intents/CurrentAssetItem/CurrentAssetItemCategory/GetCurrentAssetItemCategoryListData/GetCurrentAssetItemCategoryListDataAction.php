<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\GetCurrentAssetItemCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemCategory;

class GetCurrentAssetItemCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // CurrentAssetItemCategory Data Validation
        $getCurrentAssetItemCategoryListDataUserDTO = GetCurrentAssetItemCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $currentAssetItemCategoryListData = CurrentAssetItemCategory::where(function (Builder $current_asset_item_category_query_group1) use ($getCurrentAssetItemCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getCurrentAssetItemCategoryListDataUserDTO) && $getCurrentAssetItemCategoryListDataUserDTO['group_filter'] != '') {
                if ($getCurrentAssetItemCategoryListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getCurrentAssetItemCategoryListDataUserDTO['group_filter'] == 'Current Asset Items') {
                    $current_asset_item_category_query_group1->whereHas('current_asset_item_type', function (Builder $current_asset_item_type_query) use ($getCurrentAssetItemCategoryListDataUserDTO) {
                        return $current_asset_item_type_query->where('name', '=', $getCurrentAssetItemCategoryListDataUserDTO['group_filter']);
                    });
                } else {
                    $current_asset_item_category_query_group1->whereHas('current_asset_item_type', function (Builder $current_asset_item_type_query) use ($getCurrentAssetItemCategoryListDataUserDTO) {
                        return $current_asset_item_type_query->where('name', '=', $getCurrentAssetItemCategoryListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $current_asset_item_category_query_group2) use ($getCurrentAssetItemCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getCurrentAssetItemCategoryListDataUserDTO) && ! is_null($getCurrentAssetItemCategoryListDataUserDTO['search_filter_list']) && count($getCurrentAssetItemCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getCurrentAssetItemCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'current_asset_item_type_id' && $value != null) {
                        $current_asset_item_category_query_group2->where('current_asset_item_type_id', '=', $value);
                    }
                }
            }
        })->where(function (Builder $current_asset_item_category_query_group3) use ($getCurrentAssetItemCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getCurrentAssetItemCategoryListDataUserDTO) && $getCurrentAssetItemCategoryListDataUserDTO['search_phrase'] != '') {
                $current_asset_item_category_query_group3->where('name', 'ILIKE', '%'.$getCurrentAssetItemCategoryListDataUserDTO['search_phrase'].'%');

                $current_asset_item_category_query_group3->orWhereHas('current_asset_item_type', function (Builder $current_asset_item_type_query) use ($getCurrentAssetItemCategoryListDataUserDTO) {
                    return $current_asset_item_type_query->where('name', 'ILIKE', '%'.$getCurrentAssetItemCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['current_asset_item_type' => function (Builder $current_asset_item_type_query) {
                //
                $current_asset_item_type_query->select('id', 'name');
            }])
            ->select(
                'id',
                'name',
                'current_asset_item_type_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getCurrentAssetItemCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCurrentAssetItemCategoryListDataUserDTO['page']
            );

        return $currentAssetItemCategoryListData;
    }
}
