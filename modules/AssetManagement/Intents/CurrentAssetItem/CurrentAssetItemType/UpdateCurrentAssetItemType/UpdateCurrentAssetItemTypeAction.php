<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\UpdateCurrentAssetItemType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemType;

class UpdateCurrentAssetItemTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateCurrentAssetItemTypeUserDTO = UpdateCurrentAssetItemTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateCurrentAssetItemTypeSystemDTO = UpdateCurrentAssetItemTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $updateCurrentAssetItemTypeDTO = UpdateCurrentAssetItemTypeDTO::validate(array_merge($updateCurrentAssetItemTypeUserDTO, $updateCurrentAssetItemTypeSystemDTO));

        // Save In Database
        CurrentAssetItemType::where('id', $updateCurrentAssetItemTypeUserDTO['id'])->update($updateCurrentAssetItemTypeDTO);
        $currentAssetItemType = CurrentAssetItemType::find($updateCurrentAssetItemTypeUserDTO['id']);

        return $currentAssetItemType;
    }
}
