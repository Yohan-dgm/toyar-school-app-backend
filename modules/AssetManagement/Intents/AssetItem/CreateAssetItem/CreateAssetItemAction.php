<?php

namespace Modules\AssetManagement\Intents\AssetItem\CreateAssetItem;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\AssetItem;

class CreateAssetItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createAssetItemUserDTO = CreateAssetItemUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep

        $system_data = [
            'created_by' => $actionData['created_by'],
        ];

        // System Data Validation
        $createAssetItemSystemDTO = CreateAssetItemSystemDTO::validate($system_data);
        // Final Data Validation
        $createAssetItemDTO = CreateAssetItemDTO::validate(array_merge($createAssetItemUserDTO, $createAssetItemSystemDTO));

        // Save In Database
        $assetitem = AssetItem::create($createAssetItemDTO);

        return $assetitem;
    }
}
