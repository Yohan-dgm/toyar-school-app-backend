<?php

namespace Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItem;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\UnusableInventoryItem;

class CreateUnusableInventoryItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createUnusableInventoryItemUserDTO = CreateUnusableInventoryItemUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep

        $system_data = [
            'created_by' => $actionData['created_by'],
            'unusable_marked_by' => $actionData['unusable_marked_by'],
            'unusable_marked_date' => $actionData['unusable_marked_date'],
            'unusable_inventory_item_status_type_id' => $actionData['unusable_inventory_item_status_type_id'],

        ];

        // System Data Validation
        $createUnusableInventoryItemSystemDTO = CreateUnusableInventoryItemSystemDTO::validate($system_data);
        // Final Data Validation
        $createUnusableInventoryItemDTO = CreateUnusableInventoryItemDTO::validate(array_merge($createUnusableInventoryItemUserDTO, $createUnusableInventoryItemSystemDTO));

        // Save In Database
        $Unusableinventoryitem = UnusableInventoryItem::create($createUnusableInventoryItemDTO);

        return $Unusableinventoryitem;
    }
}
