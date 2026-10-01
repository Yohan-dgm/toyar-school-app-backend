<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\GetFixedAssetItemTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemType;

class GetFixedAssetItemTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // FixedAssetItemType Data Validation
        $getFixedAssetItemTypeListDataUserDTO = GetFixedAssetItemTypeListDataUserDTO::validate($payloadArray);

        // Action
        $fixedAssetItemTypeListData = FixedAssetItemType::where(function (Builder $fixedAssetItemType_query_group1) use ($getFixedAssetItemTypeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getFixedAssetItemTypeListDataUserDTO) && $getFixedAssetItemTypeListDataUserDTO['group_filter'] != '') {
                if ($getFixedAssetItemTypeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $fixedAssetItemType_query_group2) use ($getFixedAssetItemTypeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getFixedAssetItemTypeListDataUserDTO) && ! is_null($getFixedAssetItemTypeListDataUserDTO['search_filter_list']) && count($getFixedAssetItemTypeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getFixedAssetItemTypeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $fixedAssetItemType_query_group3) use ($getFixedAssetItemTypeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getFixedAssetItemTypeListDataUserDTO) && $getFixedAssetItemTypeListDataUserDTO['search_phrase'] != '') {
                $fixedAssetItemType_query_group3->where('name', 'ILIKE', '%'.$getFixedAssetItemTypeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getFixedAssetItemTypeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getFixedAssetItemTypeListDataUserDTO['page']
            );

        return $fixedAssetItemTypeListData;
    }
}
