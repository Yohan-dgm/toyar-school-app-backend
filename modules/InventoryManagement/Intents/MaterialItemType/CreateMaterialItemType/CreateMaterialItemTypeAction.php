<?php

namespace Modules\InventoryManagement\Intents\MaterialItemType\CreateMaterialItemType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemType;

class CreateMaterialItemTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createMaterialItemTypeUserDTO = CreateMaterialItemTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createMaterialItemTypeSystemDTO = CreateMaterialItemTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $createMaterialItemTypeDTO = CreateMaterialItemTypeDTO::validate(array_merge($createMaterialItemTypeUserDTO, $createMaterialItemTypeSystemDTO));

        // Save In Database
        $createMaterialItemType = MaterialItemType::create($createMaterialItemTypeDTO);

        return $createMaterialItemType;
    }
}
