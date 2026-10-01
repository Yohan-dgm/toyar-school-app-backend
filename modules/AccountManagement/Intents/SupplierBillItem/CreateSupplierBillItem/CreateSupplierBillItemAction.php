<?php

namespace Modules\AccountManagement\Intents\SupplierBillItem\CreateSupplierBillItem;

use Modules\AccountManagement\Models\SupplierBillItem;

class CreateSupplierBillItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createSupplierBillItemUserDTO = CreateSupplierBillItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['purchase_order_id'] = $actionData['purchase_order_id'];
        $system_data['created_by'] = $actionData['user_id'];

        $createSupplierBillItemSystemDTO = CreateSupplierBillItemSystemDTO::validate($system_data);
        $createSupplierBillItemDTO = CreateSupplierBillItemDTO::validate(array_merge($createSupplierBillItemUserDTO, $createSupplierBillItemSystemDTO));

        $supplierBillItem = SupplierBillItem::create($createSupplierBillItemDTO);

        return $supplierBillItem;
    }
}
