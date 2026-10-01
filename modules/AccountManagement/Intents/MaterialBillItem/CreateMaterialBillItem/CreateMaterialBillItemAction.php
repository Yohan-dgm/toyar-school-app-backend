<?php

namespace Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem;

use Illuminate\Support\Facades\DB;
use Modules\AccountManagement\Models\MaterialBillItem;
use Modules\InventoryManagement\Models\InventoryItem;

class CreateMaterialBillItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createMaterialBillItemUserDTO = CreateMaterialBillItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['billed_quantity'] = 0;
        $system_data['issued_quantity'] = 0;

        $material_item_id = $createMaterialBillItemUserDTO['material_item_id'];
        $item_quantity = $createMaterialBillItemUserDTO['item_quantity'];

        try {
            DB::transaction(function () use ($material_item_id, $item_quantity) {
                $inventoryItems = InventoryItem::query()
                    ->where('material_item_id', $material_item_id)
                    ->where('is_active', 1)
                    ->orderBy('received_date', 'asc')
                    ->get(['id', 'current_quantity', 'received_date']);

                if ($inventoryItems->isEmpty()) {
                    throw new \Exception('No active inventory items found.');
                }

                $remainingQuantity = $item_quantity;

                foreach ($inventoryItems as $item) {
                    if ($remainingQuantity <= 0) {
                        break;
                    }

                    $currentQuantity = $item->current_quantity;

                    if ($currentQuantity >= $remainingQuantity) {
                        $newQuantity = $currentQuantity - $remainingQuantity;
                        InventoryItem::where('id', $item->id)->update([
                            'current_quantity' => $newQuantity,
                            'is_active' => $newQuantity > 0 ? 1 : 0,
                            'updated_by' => auth()->id() ?? 1,
                        ]);
                        $remainingQuantity = 0;
                    } else {
                        InventoryItem::where('id', $item->id)->update([
                            'current_quantity' => 0,
                            'is_active' => 0,
                            'updated_by' => auth()->id() ?? 1,
                        ]);
                        $remainingQuantity -= $currentQuantity;
                    }
                }

                if ($remainingQuantity > 0) {
                    throw new \Exception('Insufficient inventory to fulfill the request.', 999);
                }
            });
        } catch (\Exception $e) {
            // Return error info for parent to collect
            throw $e;
        }
        $createMaterialBillItemSystemDTO = CreateMaterialBillItemSystemDTO::validate($system_data);
        $createMaterialBillItemDTO = CreateMaterialBillItemDTO::validate(array_merge($createMaterialBillItemUserDTO, $createMaterialBillItemSystemDTO));
        $materialBillItem = MaterialBillItem::create($createMaterialBillItemDTO);

        return $materialBillItem;
    }
}
