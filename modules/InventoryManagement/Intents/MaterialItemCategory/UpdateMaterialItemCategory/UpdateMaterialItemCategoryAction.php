<?php

namespace Modules\InventoryManagement\Intents\MaterialItemCategory\UpdateMaterialItemCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemCategory;

class UpdateMaterialItemCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateMaterialItemCategoryUserDTO = UpdateMaterialItemCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateMaterialItemCategorySystemDTO = UpdateMaterialItemCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $updateMaterialItemCategoryDTO = UpdateMaterialItemCategoryDTO::validate(array_merge($updateMaterialItemCategoryUserDTO, $updateMaterialItemCategorySystemDTO));

        // Save In Database
        MaterialItemCategory::where('id', $updateMaterialItemCategoryUserDTO['id'])->update($updateMaterialItemCategoryDTO);
        $materialItemCategory = MaterialItemCategory::find($updateMaterialItemCategoryUserDTO['id']);

        return $materialItemCategory;
    }
}
