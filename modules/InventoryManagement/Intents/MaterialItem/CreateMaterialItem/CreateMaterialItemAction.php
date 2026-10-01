<?php

namespace Modules\InventoryManagement\Intents\MaterialItem\CreateMaterialItem;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItem;
use Modules\InventoryManagement\Models\MaterialItemUnitPrice;

class CreateMaterialItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createMaterialItemUserDTO = CreateMaterialItemUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['serial_number_prefix'] = 'NEXIS/MAT-ITEM';
        $maxDigits = MaterialItem::where(function (Builder $material_item_query) {})->max('serial_number_digits');
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
        $createMaterialItemSystemDTO = CreateMaterialItemSystemDTO::validate($system_data);

        // Final Data Validation
        $createMaterialItemDTO = CreateMaterialItemDTO::validate(array_merge($createMaterialItemUserDTO, $createMaterialItemSystemDTO));

        // Save In Database
        $CreateMaterialItem = MaterialItem::create($createMaterialItemDTO);

        // save material_item_unit_price
        $update_material_item_unit_price['is_active'] = 0;
        $update_material_item_unit_price['updated_by'] = $actionData['created_by'];
        MaterialItemUnitPrice::where('material_item_id', $CreateMaterialItem->id)->update($update_material_item_unit_price);

        $create_material_item_unit_price['material_item_id'] = $CreateMaterialItem->id;
        $create_material_item_unit_price['unit_price'] = $createMaterialItemUserDTO['unit_price'];
        $create_material_item_unit_price['is_active'] = 1;
        $create_material_item_unit_price['created_by'] = $actionData['created_by'];
        MaterialItemUnitPrice::create($create_material_item_unit_price);

        return $CreateMaterialItem;
        // return $CreateMaterialItemUnitPrice;
    }
}
