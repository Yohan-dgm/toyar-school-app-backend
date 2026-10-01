<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CreateCurrentAssetItem;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItem;

class CreateCurrentAssetItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createCurrentAssetItemUserDTO = CreateCurrentAssetItemUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['serial_number_prefix'] = 'NEXIS/CA-ITEM';
        $maxDigits = CurrentAssetItem::where(function (Builder $current_asset_item_query) {})->max('serial_number_digits');
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
        $createCurrentAssetItemSystemDTO = CreateCurrentAssetItemSystemDTO::validate($system_data);

        // Final Data Validation
        $createCurrentAssetItemDTO = CreateCurrentAssetItemDTO::validate(array_merge($createCurrentAssetItemUserDTO, $createCurrentAssetItemSystemDTO));

        // Save In Database
        $CreateCurrentAssetItem = CurrentAssetItem::create($createCurrentAssetItemDTO);

        return $CreateCurrentAssetItem;
    }
}
