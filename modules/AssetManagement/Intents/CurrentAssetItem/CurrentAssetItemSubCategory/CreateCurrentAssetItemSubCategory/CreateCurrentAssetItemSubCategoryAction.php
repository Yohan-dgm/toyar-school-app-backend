<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemSubCategory\CreateCurrentAssetItemSubCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemSubCategory;

class CreateCurrentAssetItemSubCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createCurrentAssetItemSubCategoryUserDTO = CreateCurrentAssetItemSubCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createCurrentAssetItemSubCategorySystemDTO = CreateCurrentAssetItemSubCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createCurrentAssetItemSubCategoryDTO = CreateCurrentAssetItemSubCategoryDTO::validate(array_merge($createCurrentAssetItemSubCategoryUserDTO, $createCurrentAssetItemSubCategorySystemDTO));

        // Save In Database
        $createCurrentAssetItemSubCategory = CurrentAssetItemSubCategory::create($createCurrentAssetItemSubCategoryDTO);

        return $createCurrentAssetItemSubCategory;
    }
}
