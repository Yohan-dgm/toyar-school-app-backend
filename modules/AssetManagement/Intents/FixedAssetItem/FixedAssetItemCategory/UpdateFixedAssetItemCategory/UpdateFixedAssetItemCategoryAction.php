<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\UpdateFixedAssetItemCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemCategory;

class UpdateFixedAssetItemCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateFixedAssetItemCategoryUserDTO = UpdateFixedAssetItemCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateFixedAssetItemCategorySystemDTO = UpdateFixedAssetItemCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $updateFixedAssetItemCategoryDTO = UpdateFixedAssetItemCategoryDTO::validate(array_merge($updateFixedAssetItemCategoryUserDTO, $updateFixedAssetItemCategorySystemDTO));

        // Save In Database
        FixedAssetItemCategory::where('id', $updateFixedAssetItemCategoryUserDTO['id'])->update($updateFixedAssetItemCategoryDTO);
        $fixedAssetItemCategory = FixedAssetItemCategory::find($updateFixedAssetItemCategoryUserDTO['id']);

        return $fixedAssetItemCategory;
    }
}
