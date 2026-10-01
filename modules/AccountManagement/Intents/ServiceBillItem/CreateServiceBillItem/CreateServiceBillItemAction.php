<?php

namespace Modules\AccountManagement\Intents\ServiceBillItem\CreateServiceBillItem;

use Modules\AccountManagement\Models\ItemRate;
use Modules\AccountManagement\Models\ServiceBillItem;

class CreateServiceBillItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createServiceBillItemUserDTO = CreateServiceBillItemUserDTO::validate($payloadArray);

        $service_item_id = $createServiceBillItemUserDTO['service_item_id'];

        $itemRate = ItemRate::where([
            ['service_item_id', $service_item_id],
            ['is_active', true],
        ])->first();

        if (! $itemRate) {

            $rate_id = 0;
            $rate = 1;
            $subtotal = $rate * $createServiceBillItemUserDTO['quantity'];
            $total = $subtotal;
        } else {

            $rate_id = $itemRate->id;
            $rate = $itemRate->rate;
            $subtotal = $rate * $createServiceBillItemUserDTO['quantity'];
            $total = $subtotal;
        }

        $system_data = [
            'created_by' => $actionData['created_by'],
            'rate_id' => $rate_id,
            'rate' => $rate,
            'subtotal' => $subtotal,
            'total' => $total,
        ];

        $createServiceBillItemSystemDTO = CreateServiceBillItemSystemDTO::validate($system_data);
        $createServiceBillItemDTO = CreateServiceBillItemDTO::validate(array_merge($createServiceBillItemUserDTO, $createServiceBillItemSystemDTO));

        $ServiceBillItem = ServiceBillItem::create($createServiceBillItemDTO);

        return $ServiceBillItem;
    }
}
