<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\GetCurrentAssetItemTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemType;

class GetCurrentAssetItemTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // CurrentAssetItemType Data Validation
        $getCurrentAssetItemTypeListDataUserDTO = GetCurrentAssetItemTypeListDataUserDTO::validate($payloadArray);

        // Action
        $currentAssetItemTypeListData = CurrentAssetItemType::where(function (Builder $currentAssetItemType_query_group1) use ($getCurrentAssetItemTypeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getCurrentAssetItemTypeListDataUserDTO) && $getCurrentAssetItemTypeListDataUserDTO['group_filter'] != '') {
                if ($getCurrentAssetItemTypeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $currentAssetItemType_query_group2) use ($getCurrentAssetItemTypeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getCurrentAssetItemTypeListDataUserDTO) && ! is_null($getCurrentAssetItemTypeListDataUserDTO['search_filter_list']) && count($getCurrentAssetItemTypeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getCurrentAssetItemTypeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $currentAssetItemType_query_group3) use ($getCurrentAssetItemTypeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getCurrentAssetItemTypeListDataUserDTO) && $getCurrentAssetItemTypeListDataUserDTO['search_phrase'] != '') {
                $currentAssetItemType_query_group3->where('name', 'ILIKE', '%'.$getCurrentAssetItemTypeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getCurrentAssetItemTypeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCurrentAssetItemTypeListDataUserDTO['page']
            );

        return $currentAssetItemTypeListData;
    }
}
