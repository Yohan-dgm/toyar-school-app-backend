<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNote\UpdateGoodsReceivedNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\CreateGoodsReceivedNoteItem\CreateGoodsReceivedNoteItemAction;
use Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\CreateGoodsReceivedNoteItem\CreateGoodsReceivedNoteItemUserDTO;
use Modules\InventoryManagement\Models\GoodsReceivedNote;
use Modules\InventoryManagement\Models\GoodsReceivedNoteAttachment;
use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;
use Modules\InventoryManagement\Models\InventoryItem;

class UpdateGoodsReceivedNoteAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateGoodsReceivedNoteUserDTO = UpdateGoodsReceivedNoteUserDTO::validate($payloadArray);

        $updateGoodsReceivedNoteUserDTO['reference_number'] = is_null($updateGoodsReceivedNoteUserDTO['reference_number'] == 'null') || $updateGoodsReceivedNoteUserDTO['reference_number'] == 'null' ? null : $updateGoodsReceivedNoteUserDTO['reference_number'];
        $updateGoodsReceivedNoteUserDTO['office_notes'] = is_null($updateGoodsReceivedNoteUserDTO['office_notes'] == 'null') || $updateGoodsReceivedNoteUserDTO['office_notes'] == 'null' ? null : $updateGoodsReceivedNoteUserDTO['office_notes'];

        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        $updateGoodsReceivedNoteSystemDTO = UpdateGoodsReceivedNoteSystemDTO::validate($system_data);
        $updateGoodsReceivedNoteDTO = UpdateGoodsReceivedNoteDTO::validate(array_merge($updateGoodsReceivedNoteUserDTO, $updateGoodsReceivedNoteSystemDTO));
        GoodsReceivedNote::where('id', $updateGoodsReceivedNoteUserDTO['id'])->update($updateGoodsReceivedNoteDTO);

        // delete existing bill items
        GoodsReceivedNote::where('id', $updateGoodsReceivedNoteUserDTO['id'])->first()->goods_received_note_item_list()->delete();
        // create new bill items
        $goodsReceivedNoteItemList = $actionData['goods_received_note_item_list'] ?? [];
        foreach ($goodsReceivedNoteItemList as $item) {
            $item = json_decode($item, true);
            $item['goods_received_note_id'] = $updateGoodsReceivedNoteUserDTO['id'];
            $createGoodsReceivedNoteItemUserDTO = CreateGoodsReceivedNoteItemUserDTO::validate($item);
            $goodsReceivedNoteItemActionData = [
                'purchase_order_id' => $updateGoodsReceivedNoteUserDTO['purchase_order_id'],
                'user_id' => $actionData['user_id'],
            ];
            CreateGoodsReceivedNoteItemAction::run($createGoodsReceivedNoteItemUserDTO, $goodsReceivedNoteItemActionData);
        }

        $updatedGoodsReceivedNote = GoodsReceivedNote::find($updateGoodsReceivedNoteUserDTO['id']);

        // Updade Saved Attachments
        if (is_null($actionData['goods_received_note_attachment_list']) && count($updatedGoodsReceivedNote->goods_received_note_attachment_list) > 0) {
            $persistedAttachmentList = $updatedGoodsReceivedNote->goods_received_note_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = $persistedFileNameList;
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    GoodsReceivedNoteAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/inventory-management/goods-received-note/$updatedGoodsReceivedNote->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }
        if (! is_null($actionData['goods_received_note_attachment_list']) && count($actionData['goods_received_note_attachment_list']) > 0 && count($updatedGoodsReceivedNote->goods_received_note_attachment_list) > 0) {
            $persistedAttachmentList = $updatedGoodsReceivedNote->goods_received_note_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = array_merge(array_diff($persistedFileNameList, $actionData['goods_received_note_attachment_list']), array_diff($actionData['goods_received_note_attachment_list'], $persistedFileNameList));
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    GoodsReceivedNoteAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/inventory-management/goods-received-note/$updatedGoodsReceivedNote->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }

        // Create Unsaved Attachments
        if (! is_null($actionData['goods_received_note_unsaved_attachment_list']) && count($actionData['goods_received_note_unsaved_attachment_list']) > 0) {
            foreach ($actionData['goods_received_note_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/inventory-management/goods-received-note/$updatedGoodsReceivedNote->serial_number_digits/";
                $data = [];
                $data['goods_received_note_id'] = $updatedGoodsReceivedNote->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($updatedGoodsReceivedNote->serial_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $goodsReceivedNoteAttachment = GoodsReceivedNoteAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/inventory-management/goods-received-note/$updatedGoodsReceivedNote->serial_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        $updatedGoodsReceivedNote = GoodsReceivedNote::with(['goods_received_note_item_list' => function (Builder $goods_received_note_item_list_query) {
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
        }])->select('*')->find($updateGoodsReceivedNoteUserDTO['id']);

        // Transfer GRN Items to Inventory Item
        if ($updateGoodsReceivedNoteUserDTO['is_receival_complete'] == 'Yes') {
            $goodsReceivedNoteItemList = GoodsReceivedNoteItem::where('goods_received_note_id', $updatedGoodsReceivedNote->id)->get();
            foreach ($goodsReceivedNoteItemList as $item) {
                $data = [];
                $data['goods_received_note_id'] = $updatedGoodsReceivedNote->id;
                $data['material_item_id'] = $item->purchase_order_item->material_item->id;
                $data['received_date'] = $updatedGoodsReceivedNote->date;
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

        return $updatedGoodsReceivedNote;
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
