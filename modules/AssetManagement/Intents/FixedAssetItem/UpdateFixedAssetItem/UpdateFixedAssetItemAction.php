<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\UpdateFixedAssetItem;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItem;

class UpdateFixedAssetItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateFixedAssetItemUserDTO = UpdateFixedAssetItemUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateFixedAssetItemSystemDTO = UpdateFixedAssetItemSystemDTO::validate($system_data);

        // Final Data Validation
        $updateFixedAssetItemDTO = UpdateFixedAssetItemDTO::validate(array_merge($updateFixedAssetItemUserDTO, $updateFixedAssetItemSystemDTO));

        // Save In Database
        FixedAssetItem::where('id', $updateFixedAssetItemUserDTO['id'])->update($updateFixedAssetItemDTO);
        $fixedAssetItem = FixedAssetItem::find($updateFixedAssetItemUserDTO['id']);

        return $fixedAssetItem;
    }
}
