<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\CreateCurrentAssetItemCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemCategory;

class CreateCurrentAssetItemCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createCurrentAssetItemCategoryUserDTO = CreateCurrentAssetItemCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createCurrentAssetItemCategorySystemDTO = CreateCurrentAssetItemCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createCurrentAssetItemCategoryDTO = CreateCurrentAssetItemCategoryDTO::validate(array_merge($createCurrentAssetItemCategoryUserDTO, $createCurrentAssetItemCategorySystemDTO));

        // Save In Database
        $CreateCurrentAssetItemCategory = CurrentAssetItemCategory::create($createCurrentAssetItemCategoryDTO);

        return $CreateCurrentAssetItemCategory;
    }
}
