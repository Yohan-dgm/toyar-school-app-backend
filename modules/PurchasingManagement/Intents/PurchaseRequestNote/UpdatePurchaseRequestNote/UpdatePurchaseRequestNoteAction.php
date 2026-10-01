<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\UpdatePurchaseRequestNote;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;

class UpdatePurchaseRequestNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updatePurchaseRequestNoteUserDTO = UpdatePurchaseRequestNoteUserDTO::validate($payloadArray);

        if ($updatePurchaseRequestNoteUserDTO['item_type'] == 'Material Item') {
            $updatePurchaseRequestNoteUserDTO['service_item_description'] = null;
        } elseif ($updatePurchaseRequestNoteUserDTO['item_type'] == 'Service Item') {
            $updatePurchaseRequestNoteUserDTO['material_item_id'] = null;
        }

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updatePurchaseRequestNoteSystemDTO = UpdatePurchaseRequestNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $updatePurchaseRequestNoteDTO = UpdatePurchaseRequestNoteDTO::validate(array_merge($updatePurchaseRequestNoteUserDTO, $updatePurchaseRequestNoteSystemDTO));

        // Save In Database
        PurchaseRequestNote::where('id', $updatePurchaseRequestNoteUserDTO['id'])->update($updatePurchaseRequestNoteDTO);
        $purchase_request_note = PurchaseRequestNote::find($updatePurchaseRequestNoteUserDTO['id']);

        return $purchase_request_note;
    }
}
