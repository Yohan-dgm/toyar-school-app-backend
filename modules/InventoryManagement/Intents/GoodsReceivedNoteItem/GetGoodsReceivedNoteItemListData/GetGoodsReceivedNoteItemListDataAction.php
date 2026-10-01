<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\GetGoodsReceivedNoteItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;

class GetGoodsReceivedNoteItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // GoodsReceivedNoteItem Data Validation
        $getGoodsReceivedNoteItemListDataUserDTO = GetGoodsReceivedNoteItemListDataUserDTO::validate($payloadArray);

        // Action
        $goods_received_note_item = GoodsReceivedNoteItem::where(function (Builder $goods_received_note_item_group1) use ($getGoodsReceivedNoteItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getGoodsReceivedNoteItemListDataUserDTO['group_filter']) && $getGoodsReceivedNoteItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $goods_received_note_item_group2) use ($getGoodsReceivedNoteItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getGoodsReceivedNoteItemListDataUserDTO['search_filter_list'])) {
                foreach ($getGoodsReceivedNoteItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $goods_received_note_item_group3) use ($getGoodsReceivedNoteItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getGoodsReceivedNoteItemListDataUserDTO) && $getGoodsReceivedNoteItemListDataUserDTO['search_phrase'] != '') {
            }
        })->with(['material_item' => function (Builder $material_item_query) {
            //
            $material_item_query->with(['material_item_type' => function (Builder $material_item_type_query) {
                //
                $material_item_type_query->select('*');
            }])->with(['material_item_category' => function (Builder $material_item_category_query) {
                //
                $material_item_category_query->select('*');
            }])->with(['unit' => function (Builder $unit_query) {
                //
                $unit_query->select('*');
            }])->select('*');
        }])->select(
            'goods_received_note_id',
            'purchase_order_id',
            'purchase_order_item_id',
            'ordered_quantity',
            'item_unit',
            'received_quantity',
            'received_by_id',
            'shelf_life_start_date',
            'shelf_life_end_date',
            'is_goods_received_note_item_complete',
            'created_by',
            'updated_by'
        )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getGoodsReceivedNoteItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getGoodsReceivedNoteItemListDataUserDTO['page']
            );

        return $goods_received_note_item;
    }
}
