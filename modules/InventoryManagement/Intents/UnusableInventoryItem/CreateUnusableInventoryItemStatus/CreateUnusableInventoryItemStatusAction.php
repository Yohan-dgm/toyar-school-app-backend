<?php

namespace Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItemStatus;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\InventoryItem;
use Modules\InventoryManagement\Models\UnusableInventoryItem;

class CreateUnusableInventoryItemStatusAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $CreateUnusableInventoryItemStatusUserDTO = CreateUnusableInventoryItemStatusUserDTO::validate($payloadArray);

        $system_data = [];
        // System Data Validation
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['unusable_inventory_item_status_type_id'] = $actionData['unusable_inventory_item_status_type_id'];

        $CreateUnusableInventoryItemStatusSystemDTO = CreateUnusableInventoryItemStatusSystemDTO::validate($system_data);

        // Final Data Validation
        $CreateUnusableInventoryItemStatusDTO = CreateUnusableInventoryItemStatusDTO::validate(array_merge($CreateUnusableInventoryItemStatusUserDTO, $CreateUnusableInventoryItemStatusSystemDTO));

        // Data Prep
        $data['updated_by'] = $CreateUnusableInventoryItemStatusDTO['updated_by'];
        $data['unusable_inventory_item_status_type_id'] = $CreateUnusableInventoryItemStatusDTO['unusable_inventory_item_status_type_id'];

        $updateUnusableInventoryItem = UnusableInventoryItem::where('id', $CreateUnusableInventoryItemStatusUserDTO['id'])->update($data);

        //minus unusable quantity from inventory item
        $inventoryItems = InventoryItem::where('id', $CreateUnusableInventoryItemStatusUserDTO['id'])
            ->orderBy('created_at', 'asc')
            ->get();

        $unusable_inventory_item_quantity = UnusableInventoryItem::where('id', $CreateUnusableInventoryItemStatusUserDTO['id'])->first();
        $remainingUnusableQuantity = $unusable_inventory_item_quantity->unusable_quantity;

        foreach ($inventoryItems as $inventoryItem) {
            if ($remainingUnusableQuantity <= 0) {
                break;
            }
            // Update the inventory item
            $inventoryItem->current_quantity = $inventoryItem->current_quantity - $remainingUnusableQuantity;
            $inventoryItem->save();
        }

        return $updateUnusableInventoryItem;

    }
}
