<?php

namespace Modules\AccountManagement\Intents\ItemRate\CreateItemRate;

use Modules\AccountManagement\Models\ItemRate;
use Modules\AccountManagement\Models\ItemRateStatus;

class CreateItemRateAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Validate User Data
        $createItemRateUserDTO = CreateItemRateUserDTO::validate($payloadArray);

        // Prepare System Data
        $system_data = [
            'created_by' => $actionData['created_by'],
            'status_changed_by_id' => $actionData['status_changed_by_id'],
            'item_rate_status_id' => null,
            'is_active' => false,
        ];

        // Check for existing material item
        if (! empty($createItemRateUserDTO['material_item_id'])) {
            $existingItem = ItemRate::where('material_item_id', $createItemRateUserDTO['material_item_id'])->orderBy('id', 'desc')->first();
            $system_data['version'] = $existingItem ? $existingItem->version + 1 : 1;
        }

        // Check for existing service item
        if (! empty($createItemRateUserDTO['service_item_id'])) {
            $existingItem = ItemRate::where('service_item_id', $createItemRateUserDTO['service_item_id'])->orderBy('id', 'desc')->first();
            $system_data['version'] = $existingItem ? $existingItem->version + 1 : 1;
        }

        // Check for existing exam service charge item
        if (! empty($createItemRateUserDTO['exam_service_charge_id'])) {
            $existingItem = ItemRate::where('exam_service_charge_id', $createItemRateUserDTO['exam_service_charge_id'])->orderBy('id', 'desc')->first();
            $system_data['version'] = $existingItem ? $existingItem->version + 1 : 1;
        }

        // Validate System Data
        $createItemRateSystemDTO = CreateItemRateSystemDTO::validate($system_data);

        // Merge and Validate Final Data
        $createItemRateDTO = CreateItemRateDTO::validate(array_merge($createItemRateUserDTO, $createItemRateSystemDTO));

        // Save in Database
        $createItemRate = ItemRate::create($createItemRateDTO);

        // Create Item Rate Status
        $itemRateStatusData = [
            'item_rate_id' => $createItemRate->id,
            'item_rate_status_type_id' => 1,
            'status_changed_by_id' => $actionData['status_changed_by_id'] ?? null,
            'notes' => $createItemRateUserDTO['notes'] ?? null,
            'is_active' => true,
        ];
        $createItemRateStatus = ItemRateStatus::create($itemRateStatusData);

        // Update Item Rate Status ID
        $createItemRate->update(['item_rate_status_id' => $createItemRateStatus->id]);

        return $createItemRate;
    }
}
