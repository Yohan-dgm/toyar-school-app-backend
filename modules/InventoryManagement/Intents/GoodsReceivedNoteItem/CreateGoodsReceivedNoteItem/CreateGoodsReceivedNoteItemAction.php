<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\CreateGoodsReceivedNoteItem;

use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;

class CreateGoodsReceivedNoteItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createGoodsReceivedNoteItemUserDTO = CreateGoodsReceivedNoteItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['purchase_order_id'] = $actionData['purchase_order_id'];
        $system_data['created_by'] = $actionData['user_id'];

        $createGoodsReceivedNoteItemSystemDTO = CreateGoodsReceivedNoteItemSystemDTO::validate($system_data);
        $createGoodsReceivedNoteItemDTO = CreateGoodsReceivedNoteItemDTO::validate(array_merge($createGoodsReceivedNoteItemUserDTO, $createGoodsReceivedNoteItemSystemDTO));

        $goodsReceivedNoteItem = GoodsReceivedNoteItem::create($createGoodsReceivedNoteItemDTO);

        return $goodsReceivedNoteItem;
    }
}
