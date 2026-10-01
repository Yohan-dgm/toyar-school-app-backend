<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemSubCategory\CreateFixedAssetItemSubCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemSubCategory;

class CreateFixedAssetItemSubCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createFixedAssetItemSubCategoryUserDTO = CreateFixedAssetItemSubCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createFixedAssetItemSubCategorySystemDTO = CreateFixedAssetItemSubCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createFixedAssetItemSubCategoryDTO = CreateFixedAssetItemSubCategoryDTO::validate(array_merge($createFixedAssetItemSubCategoryUserDTO, $createFixedAssetItemSubCategorySystemDTO));

        // Save In Database
        $createFixedAssetItemSubCategory = FixedAssetItemSubCategory::create($createFixedAssetItemSubCategoryDTO);

        return $createFixedAssetItemSubCategory;
    }
}
