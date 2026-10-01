<?php

namespace Modules\InventoryManagement\Intents\MaterialItemType\GetMaterialItemTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemType;

class GetMaterialItemTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // MaterialItemType Data Validation
        $getMaterialItemTypeListDataUserDTO = GetMaterialItemTypeListDataUserDTO::validate($payloadArray);

        // Action
        $materialItemTypeListData = MaterialItemType::where(function (Builder $materialItemType_query_group1) use ($getMaterialItemTypeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getMaterialItemTypeListDataUserDTO) && $getMaterialItemTypeListDataUserDTO['group_filter'] != '') {
                if ($getMaterialItemTypeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $materialItemType_query_group2) use ($getMaterialItemTypeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getMaterialItemTypeListDataUserDTO) && ! is_null($getMaterialItemTypeListDataUserDTO['search_filter_list']) && count($getMaterialItemTypeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getMaterialItemTypeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $materialItemType_query_group3) use ($getMaterialItemTypeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getMaterialItemTypeListDataUserDTO) && $getMaterialItemTypeListDataUserDTO['search_phrase'] != '') {
                $materialItemType_query_group3->where('name', 'ILIKE', '%'.$getMaterialItemTypeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getMaterialItemTypeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMaterialItemTypeListDataUserDTO['page']
            );

        return $materialItemTypeListData;
    }
}
