<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNoteStatus\CreatePurchaseRequestNoteStatus;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;
use Modules\PurchasingManagement\Models\PurchaseRequestNoteStatus;

class CreatePurchaseRequestNoteStatusAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createPurchaseRequestNoteStatusUserDTO = CreatePurchaseRequestNoteStatusUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];
        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['status_changed_by_id'] = $actionData['status_changed_by_id'];
        $system_data['is_active'] = true;

        // System Data Validation
        $createPurchaseRequestNoteStatusSystemDTO = CreatePurchaseRequestNoteStatusSystemDTO::validate($system_data);

        // Final Data Validation
        $createPurchaseRequestNoteStatusDTO = CreatePurchaseRequestNoteStatusDTO::validate(array_merge($createPurchaseRequestNoteStatusUserDTO, $createPurchaseRequestNoteStatusSystemDTO));

        // Save In Database
        $purchaseRequestNoteStatusList = PurchaseRequestNoteStatus::where('purchase_request_note_id', $createPurchaseRequestNoteStatusDTO['purchase_request_note_id'])->get();

        // make other statuses inactive
        if (! is_null($purchaseRequestNoteStatusList)) {
            foreach ($purchaseRequestNoteStatusList as $purchaseRequestNoteStatus) {
                $data = [];
                $data['is_active'] = false;
                PurchaseRequestNoteStatus::where('id', $purchaseRequestNoteStatus->id)->update($data);
            }
        }

        // create new PurchaseRequestNoteStatus
        $purchaseRequestNoteStatus = PurchaseRequestNoteStatus::create($createPurchaseRequestNoteStatusDTO);

        // update PurchaseRequestNote
        $data = [];
        $data['purchase_request_note_status_id'] = $purchaseRequestNoteStatus->id;
        PurchaseRequestNote::where('id', $purchaseRequestNoteStatus->purchase_request_note_id)->update($data);

        $purchaseRequestNote = PurchaseRequestNote::where('id', $purchaseRequestNoteStatus->purchase_request_note_id)->with([
            'purchase_request_note_status.purchase_request_note_status_type' => function (Builder $query) {
                $query->select('id', 'name');
            },
        ])->first();

        return $purchaseRequestNote;
    }
}
