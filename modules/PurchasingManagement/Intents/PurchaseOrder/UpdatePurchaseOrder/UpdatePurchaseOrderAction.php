<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\UpdatePurchaseOrder;

use Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem\CreatePurchaseOrderItemAction;
use Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem\CreatePurchaseOrderItemUserDTO;
use Modules\PurchasingManagement\Models\PurchaseOrder;
use Modules\PurchasingManagement\Models\PurchaseOrderItem;

class UpdatePurchaseOrderAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updatePurchaseOrderUserDTO = UpdatePurchaseOrderUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        $updatePurchaseOrderSystemDTO = UpdatePurchaseOrderSystemDTO::validate($system_data);
        $updatePurchaseOrderDTO = UpdatePurchaseOrderDTO::validate(array_merge($updatePurchaseOrderUserDTO, $updatePurchaseOrderSystemDTO));
        PurchaseOrder::where('id', $updatePurchaseOrderUserDTO['id'])->update($updatePurchaseOrderDTO);

        $purchaseOrderItemList = $updatePurchaseOrderUserDTO['purchase_order_item_list'] ?? [];
        // set client side existing item id list
        $clientSideExistingItemIdList = [];
        foreach ($purchaseOrderItemList as $item) {
            if (! str_contains(strval($item['id']), '-')) {
                array_push($clientSideExistingItemIdList, $item['id']);
            }
        }

        // set server side existing item id list
        $serverSideExistingItemIdList = PurchaseOrderItem::where('purchase_order_id', $updatePurchaseOrderUserDTO['id'])->pluck('id')->toArray();

        // set deleted existing item id list
        // elements of the server side array which are not present in the client side array
        $deletedExistingItemIdList = array_diff($serverSideExistingItemIdList, $clientSideExistingItemIdList);

        // delete existing bill items
        // PurchaseOrder::where("id", $updatePurchaseOrderUserDTO['id'])->first()->purchase_order_item_list()->delete();

        // create or update client side bill items
        foreach ($purchaseOrderItemList as $item) {
            if (str_contains(strval($item['id']), '-')) {
                // create new client side items
                $item['purchase_order_id'] = $updatePurchaseOrderUserDTO['id']; // Assign purchase_order_id
                $updatePurchaseOrderItemUserDTO = CreatePurchaseOrderItemUserDTO::validate($item);
                $PurchaseOrderItemactionData = ['created_by' => $actionData['updated_by']];
                CreatePurchaseOrderItemAction::run($updatePurchaseOrderItemUserDTO, $PurchaseOrderItemactionData);
            } elseif (in_array($item['id'], $serverSideExistingItemIdList)) {
                // update existing server side items
                $data = [];
                $data['purchase_order_id'] = $updatePurchaseOrderUserDTO['id'];
                $data['item_type'] = $item['item_type'];
                $data['material_item_id'] = $item['material_item_id'];
                $data['item_quantity'] = $item['item_quantity'];
                $data['print_description'] = $item['print_description'];
                $data['print_quantity'] = $item['print_quantity'];
                $data['print_unit'] = $item['print_unit'];
                $data['updated_by'] = $actionData['updated_by'];
                PurchaseOrderItem::where('id', $item['id'])->update($data);
            }
        }

        $updatedPurchaseOrder = PurchaseOrder::find($updatePurchaseOrderUserDTO['id']);

        return $updatedPurchaseOrder;
    }
}
