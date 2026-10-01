<?php

namespace Modules\InventoryManagement\Intents\InventoryItem\GetInventoryItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\InventoryItem;

class GetInventoryItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // InventoryItem Data Validation
        $getInventoryItemListDataUserDTO = GetInventoryItemListDataUserDTO::validate($payloadArray);

        // Action
        $inventoryItemListData = InventoryItem::where(function (Builder $inventoryItem_query_group1) use ($getInventoryItemListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getInventoryItemListDataUserDTO) && $getInventoryItemListDataUserDTO['group_filter'] != '') {
                if ($getInventoryItemListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $inventoryItem_query_group2) use ($getInventoryItemListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getInventoryItemListDataUserDTO) && ! is_null($getInventoryItemListDataUserDTO['search_filter_list']) && count($getInventoryItemListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getInventoryItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $inventoryItem_query_group3) use ($getInventoryItemListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getInventoryItemListDataUserDTO) && $getInventoryItemListDataUserDTO['search_phrase'] != '') {
                $inventoryItem_query_group3->where('name', 'ILIKE', '%'.$getInventoryItemListDataUserDTO['search_phrase'].'%');
            }
        })->with(['material_item' => function (Builder $material_item_query) {
            //
            $material_item_query->select('*');
        }])->with(['material_item' => function (Builder $material_item_query) {
            //
            $material_item_query->select('*');
        }])
            ->select(
                'id',
                'goods_received_note_id',
                'material_item_id',
                'received_date',
                'received_quantity',
                'issued_quantity',
                'current_quantity',
                'unit_price',
                'landed_rate',
                'landed_value',
                'is_expirable',
                'shelf_life_start_date',
                'shelf_life_end_date',
                //
                'created_by',
                'updated_by',
            )
            ->distinct('material_item_id')
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getInventoryItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getInventoryItemListDataUserDTO['page']
            );

        return $inventoryItemListData;
    }
}
