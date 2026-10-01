<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem;

use Modules\PurchasingManagement\Models\PurchaseOrderItem;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;

class CreatePurchaseOrderItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createPurchaseOrderItemUserDTO = CreatePurchaseOrderItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        // $purchaseRequestNote = PurchaseRequestNote::with('material_item', 'material_item.unit')->find($createPurchaseOrderItemUserDTO['purchase_request_note_id']);
        if ($createPurchaseOrderItemUserDTO['item_type'] == 'Material Item') {
            $system_data['ordered_quantity'] = $createPurchaseOrderItemUserDTO['item_quantity'];
        } else {
            $system_data['ordered_quantity'] = $createPurchaseOrderItemUserDTO['print_quantity'];
        }
        $system_data['billed_quantity'] = 0;
        $system_data['received_quantity'] = 0;

        $createPurchaseOrderItemSystemDTO = CreatePurchaseOrderItemSystemDTO::validate($system_data);
        $createPurchaseOrderItemDTO = CreatePurchaseOrderItemDTO::validate(array_merge($createPurchaseOrderItemUserDTO, $createPurchaseOrderItemSystemDTO));

        $purchaseOrderItem = PurchaseOrderItem::create($createPurchaseOrderItemDTO);

        return $purchaseOrderItem;
    }
}
