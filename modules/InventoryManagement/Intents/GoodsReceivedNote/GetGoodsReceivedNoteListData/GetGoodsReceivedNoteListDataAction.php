<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNote\GetGoodsReceivedNoteListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\GoodsReceivedNote;

class GetGoodsReceivedNoteListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // GoodsReceivedNote Data Validation
        $getGoodsReceivedNoteListDataUserDTO = GetGoodsReceivedNoteListDataUserDTO::validate($payloadArray);

        // Action
        $goods_received_note = GoodsReceivedNote::where(function (Builder $goods_received_note_group1) use ($getGoodsReceivedNoteListDataUserDTO) {
            // Handle group_filter
            if (! empty($getGoodsReceivedNoteListDataUserDTO['group_filter']) && $getGoodsReceivedNoteListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $goods_received_note_group2) use ($getGoodsReceivedNoteListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getGoodsReceivedNoteListDataUserDTO['search_filter_list'])) {
                foreach ($getGoodsReceivedNoteListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $goods_received_note_group3) use ($getGoodsReceivedNoteListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getGoodsReceivedNoteListDataUserDTO) && $getGoodsReceivedNoteListDataUserDTO['search_phrase'] != '') {

                $goods_received_note_group3->orWhere('serial_number', 'ILIKE', '%'.$getGoodsReceivedNoteListDataUserDTO['search_phrase'].'%');

                $goods_received_note_group3->orWhereHas('supplier', function (Builder $supplier_query) use ($getGoodsReceivedNoteListDataUserDTO) {
                    return $supplier_query->where('name', 'ILIKE', '%'.$getGoodsReceivedNoteListDataUserDTO['search_phrase'].'%');
                });

                $goods_received_note_group3->orWhereHas('goods_received_note_item_list', function (Builder $goods_received_note_item_list_query) use ($getGoodsReceivedNoteListDataUserDTO) {
                    return $goods_received_note_item_list_query->where('print_description', 'ILIKE', '%'.$getGoodsReceivedNoteListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['goods_received_note_item_list' => function (Builder $goods_received_note_item_list_query) {
                //
                $goods_received_note_item_list_query->with(['purchase_order_item' => function (Builder $purchase_order_item_query) {
                    //
                    $purchase_order_item_query->with(['material_item' => function (Builder $material_item_query) {
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
                    }])->select('*');
                }])->select('*');
            }])
            ->select(
                'id',
                'purchase_order_id',
                'date',
                'reference_number',
                'is_receival_complete',
                'office_notes',
                //
                'serial_number',
                //
                'is_goods_received_note_complete',
                'goods_received_note_status_id',
            )
            ->orderBy('serial_number_digits', 'desc')
            ->paginate(
                $perPage = $getGoodsReceivedNoteListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getGoodsReceivedNoteListDataUserDTO['page']
            );

        return $goods_received_note;
    }
}
