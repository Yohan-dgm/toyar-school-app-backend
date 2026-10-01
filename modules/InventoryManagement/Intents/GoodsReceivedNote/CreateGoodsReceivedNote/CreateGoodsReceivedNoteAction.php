<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNote\CreateGoodsReceivedNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\CreateGoodsReceivedNoteItem\CreateGoodsReceivedNoteItemAction;
use Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\CreateGoodsReceivedNoteItem\CreateGoodsReceivedNoteItemUserDTO;
use Modules\InventoryManagement\Models\GoodsReceivedNote;
use Modules\InventoryManagement\Models\GoodsReceivedNoteAttachment;
use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;
use Modules\InventoryManagement\Models\InventoryItem;

class CreateGoodsReceivedNoteAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createGoodsReceivedNoteUserDTO = CreateGoodsReceivedNoteUserDTO::validate($payloadArray);

        $createGoodsReceivedNoteUserDTO['reference_number'] = is_null($createGoodsReceivedNoteUserDTO['reference_number'] == 'null') || $createGoodsReceivedNoteUserDTO['reference_number'] == 'null' ? null : $createGoodsReceivedNoteUserDTO['reference_number'];
        $createGoodsReceivedNoteUserDTO['office_notes'] = is_null($createGoodsReceivedNoteUserDTO['office_notes'] == 'null') || $createGoodsReceivedNoteUserDTO['office_notes'] == 'null' ? null : $createGoodsReceivedNoteUserDTO['office_notes'];

        $system_data['serial_number_prefix'] = 'NY/GRN';
        $maxDigits = GoodsReceivedNote::where(function (Builder $receipt_query) {
            $serial_number_financial_year = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
            $receipt_query->where('serial_number_financial_year', '=', $serial_number_financial_year);
        })->max('serial_number_digits');

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'].'/'.$system_data['serial_number_suffix'];
        }
        $system_data['created_by'] = $actionData['user_id'];

        $createGoodsReceivedNoteSystemDTO = CreateGoodsReceivedNoteSystemDTO::validate($system_data);
        $createGoodsReceivedNoteDTO = CreateGoodsReceivedNoteDTO::validate(array_merge($createGoodsReceivedNoteUserDTO, $createGoodsReceivedNoteSystemDTO));
        $createdGoodsReceivedNote = GoodsReceivedNote::create($createGoodsReceivedNoteDTO);
        // Create Unsaved Attachments
        if (! is_null($actionData['goods_received_note_unsaved_attachment_list']) && count($actionData['goods_received_note_unsaved_attachment_list']) > 0) {
            foreach ($actionData['goods_received_note_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/inventory-management/goods-received-note/$createdGoodsReceivedNote->serial_number_digits/";
                $data = [];
                $data['goods_received_note_id'] = $createdGoodsReceivedNote->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($createdGoodsReceivedNote->serial_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $goodsReceivedNoteAttachment = GoodsReceivedNoteAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/inventory-management/goods-received-note/$createdGoodsReceivedNote->serial_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        // GRN Items
        $goodsReceivedNoteItemList = $actionData['goods_received_note_item_list'] ?? [];
        foreach ($goodsReceivedNoteItemList as $item) {
            $item = json_decode($item, true);
            $item['goods_received_note_id'] = $createdGoodsReceivedNote->id;
            $createGoodsReceivedNoteItemUserDTO = CreateGoodsReceivedNoteItemUserDTO::validate($item);
            $goodsReceivedNoteItemActionData = [
                'purchase_order_id' => $createGoodsReceivedNoteUserDTO['purchase_order_id'],
                'user_id' => $actionData['user_id'],
            ];
            CreateGoodsReceivedNoteItemAction::run($createGoodsReceivedNoteItemUserDTO, $goodsReceivedNoteItemActionData);
        }

        $createdGoodsReceivedNote = GoodsReceivedNote::with(['goods_received_note_item_list' => function (Builder $goods_received_note_item_list_query) {
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
        }])->with(['purchase_order' => function (Builder $purchase_order_query) {
            //
            $purchase_order_query->with(['supplier' => function (Builder $supplier_query) {
                //
                $supplier_query->select('id', 'name', 'serial_number');
            }])->select('*');
        }])->select('*')->find($createdGoodsReceivedNote->id);

        // Transfer GRN Items to Inventory Item
        if ($createGoodsReceivedNoteUserDTO['is_receival_complete'] == 'Yes') {
            $goodsReceivedNoteItemList = GoodsReceivedNoteItem::where('goods_received_note_id', $createdGoodsReceivedNote->id)->get();
            foreach ($goodsReceivedNoteItemList as $item) {
                $data = [];
                $data['goods_received_note_id'] = $createdGoodsReceivedNote->id;
                $data['material_item_id'] = $item->purchase_order_item->material_item->id;
                $data['received_date'] = $createdGoodsReceivedNote->date;
                $data['received_quantity'] = $item->received_quantity;
                $data['issued_quantity'] = 0;
                $data['current_quantity'] = $item->received_quantity;
                $data['unit_price'] = 0;
                $data['landed_rate'] = 0;
                $data['landed_value'] = 0;
                $data['is_active'] = 1;
                $data['is_expirable'] = $item->purchase_order_item->material_item->is_expirable;
                if ($data['is_expirable'] == true) {
                    $data['shelf_life_start_date'] = $item->shelf_life_start_date;
                    $data['shelf_life_end_date'] = $item->shelf_life_end_date;
                }
                $data['created_by'] = $actionData['user_id'];
                InventoryItem::create($data);
            }
        }

        return $createdGoodsReceivedNote;
    }

    public function getUniqueFileName($prefix, $path, $extension)
    {
        $count = 1;
        $file = '';
        if (is_null($extension)) {
            $extension = '';
        }
        do {
            if ($count == 1) {
                $file = $prefix.'-'.microtime(true).'.'.$extension;
                $count++;
            } else {
                $file = $prefix.'-'.microtime(true).'_'.$count.'.'.$extension;
                $count++;
            }
        } while (file_exists($path.$file));

        return $file;
    }
}
