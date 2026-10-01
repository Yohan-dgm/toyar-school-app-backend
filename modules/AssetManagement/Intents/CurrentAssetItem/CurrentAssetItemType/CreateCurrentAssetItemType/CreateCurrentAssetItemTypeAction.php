<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\CreateCurrentAssetItemType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemType;

class CreateCurrentAssetItemTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createCurrentAssetItemTypeUserDTO = CreateCurrentAssetItemTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createCurrentAssetItemTypeSystemDTO = CreateCurrentAssetItemTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $createCurrentAssetItemTypeDTO = CreateCurrentAssetItemTypeDTO::validate(array_merge($createCurrentAssetItemTypeUserDTO, $createCurrentAssetItemTypeSystemDTO));

        // Save In Database
        $createCurrentAssetItemType = CurrentAssetItemType::create($createCurrentAssetItemTypeDTO);

        return $createCurrentAssetItemType;
    }
}
