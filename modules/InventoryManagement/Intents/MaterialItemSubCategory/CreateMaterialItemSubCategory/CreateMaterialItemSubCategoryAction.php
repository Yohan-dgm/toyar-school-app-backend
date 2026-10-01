<?php

namespace Modules\InventoryManagement\Intents\MaterialItemSubCategory\CreateMaterialItemSubCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemSubCategory;

class CreateMaterialItemSubCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createMaterialItemSubCategoryUserDTO = CreateMaterialItemSubCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createMaterialItemSubCategorySystemDTO = CreateMaterialItemSubCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createMaterialItemSubCategoryDTO = CreateMaterialItemSubCategoryDTO::validate(array_merge($createMaterialItemSubCategoryUserDTO, $createMaterialItemSubCategorySystemDTO));

        // Save In Database
        $createMaterialItemSubCategory = MaterialItemSubCategory::create($createMaterialItemSubCategoryDTO);

        return $createMaterialItemSubCategory;
    }
}
