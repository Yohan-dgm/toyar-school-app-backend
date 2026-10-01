<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\UpdateFixedAssetItemType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemType;

class UpdateFixedAssetItemTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateFixedAssetItemTypeUserDTO = UpdateFixedAssetItemTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateFixedAssetItemTypeSystemDTO = UpdateFixedAssetItemTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $updateFixedAssetItemTypeDTO = UpdateFixedAssetItemTypeDTO::validate(array_merge($updateFixedAssetItemTypeUserDTO, $updateFixedAssetItemTypeSystemDTO));

        // Save In Database
        FixedAssetItemType::where('id', $updateFixedAssetItemTypeUserDTO['id'])->update($updateFixedAssetItemTypeDTO);
        $fixedAssetItemType = FixedAssetItemType::find($updateFixedAssetItemTypeUserDTO['id']);

        return $fixedAssetItemType;
    }
}
