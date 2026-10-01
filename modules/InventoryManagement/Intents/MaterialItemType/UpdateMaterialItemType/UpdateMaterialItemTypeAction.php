<?php

namespace Modules\InventoryManagement\Intents\MaterialItemType\UpdateMaterialItemType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemType;

class UpdateMaterialItemTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateMaterialItemTypeUserDTO = UpdateMaterialItemTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateMaterialItemTypeSystemDTO = UpdateMaterialItemTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $updateMaterialItemTypeDTO = UpdateMaterialItemTypeDTO::validate(array_merge($updateMaterialItemTypeUserDTO, $updateMaterialItemTypeSystemDTO));

        // Save In Database
        MaterialItemType::where('id', $updateMaterialItemTypeUserDTO['id'])->update($updateMaterialItemTypeDTO);
        $materialItemType = MaterialItemType::find($updateMaterialItemTypeUserDTO['id']);

        return $materialItemType;
    }
}
