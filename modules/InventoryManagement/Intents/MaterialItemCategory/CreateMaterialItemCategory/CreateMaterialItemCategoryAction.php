<?php

namespace Modules\InventoryManagement\Intents\MaterialItemCategory\CreateMaterialItemCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemCategory;

class CreateMaterialItemCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createMaterialItemCategoryUserDTO = CreateMaterialItemCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createMaterialItemCategorySystemDTO = CreateMaterialItemCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createMaterialItemCategoryDTO = CreateMaterialItemCategoryDTO::validate(array_merge($createMaterialItemCategoryUserDTO, $createMaterialItemCategorySystemDTO));

        // Save In Database
        $CreateMaterialItemCategory = MaterialItemCategory::create($createMaterialItemCategoryDTO);

        return $CreateMaterialItemCategory;
    }
}
