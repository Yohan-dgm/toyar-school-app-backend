<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\GetCurrentAssetItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItem;

class GetCurrentAssetItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // CurrentAssetItem Data Validation
        $getCurrentAssetItemListDataUserDTO = GetCurrentAssetItemListDataUserDTO::validate($payloadArray);

        // Action
        $currentAssetItemListData = CurrentAssetItem::where(function (Builder $current_asset_item_query_group1) use ($getCurrentAssetItemListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getCurrentAssetItemListDataUserDTO) && $getCurrentAssetItemListDataUserDTO['group_filter'] != '') {
                if ($getCurrentAssetItemListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $current_asset_item_query_group1->whereHas('current_asset_item_type', function (Builder $current_asset_item_type_query) use ($getCurrentAssetItemListDataUserDTO) {
                        return $current_asset_item_type_query->where('name', '=', $getCurrentAssetItemListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $CurrentAssetItem_query_group2) use ($getCurrentAssetItemListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getCurrentAssetItemListDataUserDTO) && ! is_null($getCurrentAssetItemListDataUserDTO['search_filter_list']) && count($getCurrentAssetItemListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getCurrentAssetItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $current_asset_item_query_group3) use ($getCurrentAssetItemListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getCurrentAssetItemListDataUserDTO) && $getCurrentAssetItemListDataUserDTO['search_phrase'] != '') {
                $current_asset_item_query_group3->where('name', 'ILIKE', '%'.$getCurrentAssetItemListDataUserDTO['search_phrase'].'%');

                $current_asset_item_query_group3->orWhere('serial_number', 'ILIKE', '%'.$getCurrentAssetItemListDataUserDTO['search_phrase'].'%');

                $current_asset_item_query_group3->orWhereHas('current_asset_item_category', function (Builder $current_asset_item_category_query) use ($getCurrentAssetItemListDataUserDTO) {
                    return $current_asset_item_category_query->where('name', 'ILIKE', '%'.$getCurrentAssetItemListDataUserDTO['search_phrase'].'%');
                });

                $current_asset_item_query_group3->orWhereHas('unit', function (Builder $unit_query) use ($getCurrentAssetItemListDataUserDTO) {
                    return $unit_query->where('name', 'ILIKE', '%'.$getCurrentAssetItemListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['current_asset_item_type' => function (Builder $current_asset_item_type_query) {
                //
                $current_asset_item_type_query->select('id', 'name');
            }])

            ->with(['current_asset_item_category' => function (Builder $current_asset_item_category_query) {
                //
                $current_asset_item_category_query->select('id', 'name');
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
                'current_asset_item_type_id',
                'current_asset_item_category_id',
                'unit_id'
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getCurrentAssetItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCurrentAssetItemListDataUserDTO['page']
            );

        return $currentAssetItemListData;
    }
}
