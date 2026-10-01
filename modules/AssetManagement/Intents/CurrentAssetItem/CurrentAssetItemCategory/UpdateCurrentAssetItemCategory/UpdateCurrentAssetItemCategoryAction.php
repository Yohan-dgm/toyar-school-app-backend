<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\UpdateCurrentAssetItemCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemCategory;

class UpdateCurrentAssetItemCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateCurrentAssetItemCategoryUserDTO = UpdateCurrentAssetItemCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateCurrentAssetItemCategorySystemDTO = UpdateCurrentAssetItemCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $updateCurrentAssetItemCategoryDTO = UpdateCurrentAssetItemCategoryDTO::validate(array_merge($updateCurrentAssetItemCategoryUserDTO, $updateCurrentAssetItemCategorySystemDTO));

        // Save In Database
        CurrentAssetItemCategory::where('id', $updateCurrentAssetItemCategoryUserDTO['id'])->update($updateCurrentAssetItemCategoryDTO);
        $currentAssetItemCategory = CurrentAssetItemCategory::find($updateCurrentAssetItemCategoryUserDTO['id']);

        return $currentAssetItemCategory;
    }
}
