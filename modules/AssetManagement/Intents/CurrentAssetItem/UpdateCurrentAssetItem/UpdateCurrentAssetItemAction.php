<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\UpdateCurrentAssetItem;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItem;

class UpdateCurrentAssetItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateCurrentAssetItemUserDTO = UpdateCurrentAssetItemUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateCurrentAssetItemSystemDTO = UpdateCurrentAssetItemSystemDTO::validate($system_data);

        // Final Data Validation
        $updateCurrentAssetItemDTO = UpdateCurrentAssetItemDTO::validate(array_merge($updateCurrentAssetItemUserDTO, $updateCurrentAssetItemSystemDTO));

        // Save In Database
        CurrentAssetItem::where('id', $updateCurrentAssetItemUserDTO['id'])->update($updateCurrentAssetItemDTO);
        $currentAssetItem = CurrentAssetItem::find($updateCurrentAssetItemUserDTO['id']);

        return $currentAssetItem;
    }
}
