<?php

namespace Modules\AssetManagement\Intents\AssetItem\GetAssetItemAggregatedListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\AssetItem;

class GetAssetItemAggregatedListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // AssetItem Data Validation
        $getAssetItemListDataUserDTO = GetAssetItemAggregatedListDataUserDTO::validate($payloadArray);

        // Action
        $assetItem = AssetItem::where(function (Builder $asset_item_group1) use ($getAssetItemListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getAssetItemListDataUserDTO) && $getAssetItemListDataUserDTO['group_filter'] != '') {
                if ($getAssetItemListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $asset_item_group2) use ($getAssetItemListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getAssetItemListDataUserDTO) && ! is_null($getAssetItemListDataUserDTO['search_filter_list']) && count($getAssetItemListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getAssetItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $asset_item_group3) use ($getAssetItemListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getAssetItemListDataUserDTO) && $getAssetItemListDataUserDTO['search_phrase'] != '') {
                $asset_item_group3->where('name', 'ILIKE', '%'.$getAssetItemListDataUserDTO['search_phrase'].'%');
            }
        })->with(['asset_item_list' => function (Builder $asset_item_query) {
            //
            $asset_item_query->select('id', 'current_quantity', 'asset_item_id');
        }])
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getAssetItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getAssetItemListDataUserDTO['page']
            );

        // After Intent

        return $assetItem;
    }
}
