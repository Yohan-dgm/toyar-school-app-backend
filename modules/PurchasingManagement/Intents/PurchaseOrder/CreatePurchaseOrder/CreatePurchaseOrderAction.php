<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\CreatePurchaseOrder;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem\CreatePurchaseOrderItemAction;
use Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem\CreatePurchaseOrderItemUserDTO;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class CreatePurchaseOrderAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createPurchaseOrderUserDTO = CreatePurchaseOrderUserDTO::validate($payloadArray);

        $system_data['serial_number_prefix'] = 'NY/PO';
        $maxDigits = PurchaseOrder::where(function (Builder $receipt_query) {
            $serial_number_financial_year = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
            $receipt_query->where('serial_number_financial_year', '=', $serial_number_financial_year);
        })->max('serial_number_digits');

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'].'/'.$system_data['serial_number_suffix'];
        }
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['is_purchase_order_complete'] = false;

        $createPurchaseOrderSystemDTO = CreatePurchaseOrderSystemDTO::validate($system_data);
        $createPurchaseOrderDTO = CreatePurchaseOrderDTO::validate(array_merge($createPurchaseOrderUserDTO, $createPurchaseOrderSystemDTO));
        $createdPurchaseOrder = PurchaseOrder::create($createPurchaseOrderDTO);

        $purchaseOrderItemList = $createPurchaseOrderUserDTO['purchase_order_item_list'] ?? [];
        foreach ($purchaseOrderItemList as $item) {
            $item['purchase_order_id'] = $createdPurchaseOrder->id; // Assign purchase_order_id
            $createPurchaseOrderItemUserDTO = CreatePurchaseOrderItemUserDTO::validate($item);
            $purchaseOrderItemActionData = ['created_by' => $actionData['created_by']];
            CreatePurchaseOrderItemAction::run($createPurchaseOrderItemUserDTO, $purchaseOrderItemActionData);
        }

        $createdPurchaseOrder = PurchaseOrder::find($createdPurchaseOrder->id);

        return $createdPurchaseOrder;
    }
}
