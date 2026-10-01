<?php

namespace Modules\InventoryManagement\Intents\MaterialItem\UpdateMaterialItem;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItem;
use Modules\InventoryManagement\Models\MaterialItemUnitPrice;

class UpdateMaterialItemAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateMaterialItemUserDTO = UpdateMaterialItemUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateMaterialItemSystemDTO = UpdateMaterialItemSystemDTO::validate($system_data);

        // Final Data Validation
        $updateMaterialItemDTO = UpdateMaterialItemDTO::validate(array_merge($updateMaterialItemUserDTO, $updateMaterialItemSystemDTO));

        // Save In Database
        MaterialItem::where('id', $updateMaterialItemUserDTO['id'])->update($updateMaterialItemDTO);
        $materialItem = MaterialItem::find($updateMaterialItemUserDTO['id']);

        // save material_item_unit_price
        $update_material_item_unit_price['is_active'] = 0;
        $update_material_item_unit_price['updated_by'] = $actionData['updated_by'];
        MaterialItemUnitPrice::where('material_item_id', $materialItem->id)->update($update_material_item_unit_price);

        $create_material_item_unit_price['material_item_id'] = $materialItem->id;
        $create_material_item_unit_price['unit_price'] = $updateMaterialItemDTO['unit_price'];
        $create_material_item_unit_price['is_active'] = 1;
        $create_material_item_unit_price['created_by'] = $actionData['updated_by'];
        MaterialItemUnitPrice::create($create_material_item_unit_price);

        return $materialItem;
    }
}
