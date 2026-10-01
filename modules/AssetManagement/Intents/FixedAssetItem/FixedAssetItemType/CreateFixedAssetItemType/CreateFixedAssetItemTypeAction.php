<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\CreateFixedAssetItemType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemType;

class CreateFixedAssetItemTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createFixedAssetItemTypeUserDTO = CreateFixedAssetItemTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createFixedAssetItemTypeSystemDTO = CreateFixedAssetItemTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $createFixedAssetItemTypeDTO = CreateFixedAssetItemTypeDTO::validate(array_merge($createFixedAssetItemTypeUserDTO, $createFixedAssetItemTypeSystemDTO));

        // Save In Database
        $createFixedAssetItemType = FixedAssetItemType::create($createFixedAssetItemTypeDTO);

        return $createFixedAssetItemType;
    }
}
