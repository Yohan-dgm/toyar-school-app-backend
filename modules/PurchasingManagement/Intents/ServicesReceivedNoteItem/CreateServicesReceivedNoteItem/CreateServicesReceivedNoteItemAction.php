<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\CreateServicesReceivedNoteItem;

use Modules\PurchasingManagement\Models\ServicesReceivedNoteItem;

class CreateServicesReceivedNoteItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createServicesReceivedNoteItemUserDTO = CreateServicesReceivedNoteItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['purchase_order_id'] = $actionData['purchase_order_id'];
        $system_data['created_by'] = $actionData['user_id'];

        $createServicesReceivedNoteItemSystemDTO = CreateServicesReceivedNoteItemSystemDTO::validate($system_data);
        $createServicesReceivedNoteItemDTO = CreateServicesReceivedNoteItemDTO::validate(array_merge($createServicesReceivedNoteItemUserDTO, $createServicesReceivedNoteItemSystemDTO));

        $servicesReceivedNoteItem = ServicesReceivedNoteItem::create($createServicesReceivedNoteItemDTO);

        return $servicesReceivedNoteItem;
    }
}
