<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\CreateFixedAssetItemCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemCategory;

class CreateFixedAssetItemCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createFixedAssetItemCategoryUserDTO = CreateFixedAssetItemCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createFixedAssetItemCategorySystemDTO = CreateFixedAssetItemCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createFixedAssetItemCategoryDTO = CreateFixedAssetItemCategoryDTO::validate(array_merge($createFixedAssetItemCategoryUserDTO, $createFixedAssetItemCategorySystemDTO));

        // Save In Database
        $CreateFixedAssetItemCategory = FixedAssetItemCategory::create($createFixedAssetItemCategoryDTO);

        return $CreateFixedAssetItemCategory;
    }
}
