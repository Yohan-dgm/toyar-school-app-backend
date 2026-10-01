<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\CreateFixedAssetItem;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItem;

class CreateFixedAssetItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createFixedAssetItemUserDTO = CreateFixedAssetItemUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['serial_number_prefix'] = 'NEXIS/FA-ITEM';
        $maxDigits = FixedAssetItem::where(function (Builder $fixed_asset_item_query) {})->max('serial_number_digits');
        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_digits'].'/'.$system_data['serial_number_suffix'];
        }

        // System Data Validation
        $createFixedAssetItemSystemDTO = CreateFixedAssetItemSystemDTO::validate($system_data);

        // Final Data Validation
        $createFixedAssetItemDTO = CreateFixedAssetItemDTO::validate(array_merge($createFixedAssetItemUserDTO, $createFixedAssetItemSystemDTO));

        // Save In Database
        $CreateFixedAssetItem = FixedAssetItem::create($createFixedAssetItemDTO);

        return $CreateFixedAssetItem;
    }
}
