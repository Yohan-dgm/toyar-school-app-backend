<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\GetFixedAssetItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItem;

class GetFixedAssetItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // FixedAssetItem Data Validation
        $getFixedAssetItemListDataUserDTO = GetFixedAssetItemListDataUserDTO::validate($payloadArray);

        // Action
        $fixedAssetItemListData = FixedAssetItem::where(function (Builder $fixed_asset_item_query_group1) use ($getFixedAssetItemListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getFixedAssetItemListDataUserDTO) && $getFixedAssetItemListDataUserDTO['group_filter'] != '') {
                if ($getFixedAssetItemListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $fixed_asset_item_query_group1->whereHas('fixed_asset_item_type', function (Builder $fixed_asset_item_type_query) use ($getFixedAssetItemListDataUserDTO) {
                        return $fixed_asset_item_type_query->where('name', '=', $getFixedAssetItemListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $FixedAssetItem_query_group2) use ($getFixedAssetItemListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getFixedAssetItemListDataUserDTO) && ! is_null($getFixedAssetItemListDataUserDTO['search_filter_list']) && count($getFixedAssetItemListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getFixedAssetItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $fixed_asset_item_query_group3) use ($getFixedAssetItemListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getFixedAssetItemListDataUserDTO) && $getFixedAssetItemListDataUserDTO['search_phrase'] != '') {
                $fixed_asset_item_query_group3->where('name', 'ILIKE', '%'.$getFixedAssetItemListDataUserDTO['search_phrase'].'%');

                $fixed_asset_item_query_group3->orWhere('serial_number', 'ILIKE', '%'.$getFixedAssetItemListDataUserDTO['search_phrase'].'%');

                $fixed_asset_item_query_group3->orWhereHas('fixed_asset_item_category', function (Builder $fixed_asset_item_category_query) use ($getFixedAssetItemListDataUserDTO) {
                    return $fixed_asset_item_category_query->where('name', 'ILIKE', '%'.$getFixedAssetItemListDataUserDTO['search_phrase'].'%');
                });

                $fixed_asset_item_query_group3->orWhereHas('unit', function (Builder $unit_query) use ($getFixedAssetItemListDataUserDTO) {
                    return $unit_query->where('name', 'ILIKE', '%'.$getFixedAssetItemListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['fixed_asset_item_type' => function (Builder $fixed_asset_item_type_query) {
                //
                $fixed_asset_item_type_query->select('id', 'name');
            }])

            ->with(['fixed_asset_item_category' => function (Builder $fixed_asset_item_category_query) {
                //
                $fixed_asset_item_category_query->select('id', 'name');
            }])
            ->with(['unit' => function (Builder $unit_query) {
                //
                $unit_query->select('id', 'name');
            }])
            ->select(
                'id',
                'serial_number',
                'name',
                'reorder_level',
                'fixed_asset_item_type_id',
                'fixed_asset_item_category_id',
                'unit_id'
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getFixedAssetItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getFixedAssetItemListDataUserDTO['page']
            );

        return $fixedAssetItemListData;
    }
}
