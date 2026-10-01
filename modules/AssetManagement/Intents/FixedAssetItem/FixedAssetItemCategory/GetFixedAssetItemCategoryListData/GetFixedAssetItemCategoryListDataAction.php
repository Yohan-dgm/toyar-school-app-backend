<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\GetFixedAssetItemCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemCategory;

class GetFixedAssetItemCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // FixedAssetItemCategory Data Validation
        $getFixedAssetItemCategoryListDataUserDTO = GetFixedAssetItemCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $fixedAssetItemCategoryListData = FixedAssetItemCategory::where(function (Builder $fixed_asset_item_category_query_group1) use ($getFixedAssetItemCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getFixedAssetItemCategoryListDataUserDTO) && $getFixedAssetItemCategoryListDataUserDTO['group_filter'] != '') {
                if ($getFixedAssetItemCategoryListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getFixedAssetItemCategoryListDataUserDTO['group_filter'] == 'Fixed Asset Items') {
                    $fixed_asset_item_category_query_group1->whereHas('fixed_asset_item_type', function (Builder $fixed_asset_item_type_query) use ($getFixedAssetItemCategoryListDataUserDTO) {
                        return $fixed_asset_item_type_query->where('name', '=', $getFixedAssetItemCategoryListDataUserDTO['group_filter']);
                    });
                } else {
                    $fixed_asset_item_category_query_group1->whereHas('fixed_asset_item_type', function (Builder $fixed_asset_item_type_query) use ($getFixedAssetItemCategoryListDataUserDTO) {
                        return $fixed_asset_item_type_query->where('name', '=', $getFixedAssetItemCategoryListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $fixed_asset_item_category_query_group2) use ($getFixedAssetItemCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getFixedAssetItemCategoryListDataUserDTO) && ! is_null($getFixedAssetItemCategoryListDataUserDTO['search_filter_list']) && count($getFixedAssetItemCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getFixedAssetItemCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'fixed_asset_item_type_id' && $value != null) {
                        $fixed_asset_item_category_query_group2->where('fixed_asset_item_type_id', '=', $value);
                    }
                }
            }
        })->where(function (Builder $fixed_asset_item_category_query_group3) use ($getFixedAssetItemCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getFixedAssetItemCategoryListDataUserDTO) && $getFixedAssetItemCategoryListDataUserDTO['search_phrase'] != '') {
                $fixed_asset_item_category_query_group3->where('name', 'ILIKE', '%'.$getFixedAssetItemCategoryListDataUserDTO['search_phrase'].'%');

                $fixed_asset_item_category_query_group3->orWhereHas('fixed_asset_item_type', function (Builder $fixed_asset_item_type_query) use ($getFixedAssetItemCategoryListDataUserDTO) {
                    return $fixed_asset_item_type_query->where('name', 'ILIKE', '%'.$getFixedAssetItemCategoryListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['fixed_asset_item_type' => function (Builder $fixed_asset_item_type_query) {
                //
                $fixed_asset_item_type_query->select('id', 'name');
            }])
            ->select(
                'id',
                'name',
                'fixed_asset_item_type_id',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getFixedAssetItemCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getFixedAssetItemCategoryListDataUserDTO['page']
            );

        return $fixedAssetItemCategoryListData;
    }
}
