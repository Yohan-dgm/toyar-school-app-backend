<?php

namespace Modules\AccountManagement\Intents\ServiceBill\CreateServiceBill;

use Modules\AccountManagement\Intents\ServiceBillItem\CreateServiceBillItem\CreateServiceBillItemAction;
use Modules\AccountManagement\Intents\ServiceBillItem\CreateServiceBillItem\CreateServiceBillItemUserDTO;
use Modules\AccountManagement\Models\ServiceBill;
use Modules\AccountManagement\Models\ServiceBillItem;

class CreateServiceBillAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createServiceBillUserDTO = CreateServiceBillUserDTO::validate($payloadArray);

        $ServiceBillDigits = ServiceBill::max('serial_number_digits') ?? 0;
        $serial_number_digits = $ServiceBillDigits + 1;
        $set_serial_number_prefix = 'NY/SVC-BILL';
        $serial_number_current_year = date('y');
        $serial_number_prefix = config('account_management.service_bill_prefix', $set_serial_number_prefix);
        $serial_number = "$serial_number_prefix/$serial_number_digits";

        $system_data = [
            'serial_number' => $serial_number,
            'serial_number_digits' => $serial_number_digits,
            'serial_number_prefix' => $set_serial_number_prefix,
            'serial_number_current_year' => $serial_number_current_year,
            'created_by' => $actionData['created_by'],
            'subtotal' => 0,
            'total' => 0,
        ];

        $createServiceBillSystemDTO = CreateServiceBillSystemDTO::validate($system_data);
        $createServiceBillDTO = CreateServiceBillDTO::validate(array_merge($createServiceBillUserDTO, $createServiceBillSystemDTO));

        $createServiceBill = ServiceBill::create($createServiceBillDTO);

        $serviceBillItemList = $createServiceBillUserDTO['service_bill_item_list'] ?? [];
        foreach ($serviceBillItemList as $item) {
            $item['service_bill_id'] = $createServiceBill->id; // Assign service_bill_id
            $itemDTO = CreateServiceBillItemUserDTO::validate($item);

            $ServiceBillItemactionData = ['created_by' => $actionData['created_by']];
            CreateServiceBillItemAction::run($itemDTO, $ServiceBillItemactionData);
        }

        //get total amount from service bill item table
        $serviceBillItems = ServiceBillItem::where('service_bill_id', $createServiceBill->id)->get();
        $totalAmount = 0;
        foreach ($serviceBillItems as $serviceBillItem) {
            $totalAmount += $serviceBillItem->total;
        }
        if (empty($totalAmount)) {
            $totalAmount = 0;
        }
        $system_data['subtotal'] = $totalAmount;
        $system_data['total'] = $totalAmount;

        $createServiceBillSystemDTO = CreateServiceBillSystemDTO::validate($system_data);
        $createServiceBillDTO = CreateServiceBillDTO::validate(array_merge($createServiceBillUserDTO, $createServiceBillSystemDTO));
        $createServiceBill->update($createServiceBillDTO);

        return $createServiceBill;
    }
}
