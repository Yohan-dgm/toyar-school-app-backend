<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\CreatePurchaseRequestNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;
use Modules\PurchasingManagement\Models\PurchaseRequestNoteStatus;

class CreatePurchaseRequestNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {

        // User Data Validation
        $createPurchaseRequestNoteUserDTO = CreatePurchaseRequestNoteUserDTO::validate($payloadArray);

        if ($createPurchaseRequestNoteUserDTO['item_type'] == 'Material Item') {
            $createPurchaseRequestNoteUserDTO['service_item_description'] = null;
        } elseif ($createPurchaseRequestNoteUserDTO['item_type'] == 'Service Item') {
            $createPurchaseRequestNoteUserDTO['material_item_id'] = null;
        }

        // Data Prep
        $system_data = [];
        $system_data['serial_number_prefix'] = 'NY/PRN';

        $maxDigits = PurchaseRequestNote::where(function (Builder $receipt_query) {
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

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['purchase_request_note_status_id'] = null;

        // System Data Validation
        $createPurchaseRequestNoteSystemDTO = CreatePurchaseRequestNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $createPurchaseRequestNoteDTO = CreatePurchaseRequestNoteDTO::validate(array_merge($createPurchaseRequestNoteUserDTO, $createPurchaseRequestNoteSystemDTO));

        // Save In Database
        $purchaseRequestNote = PurchaseRequestNote::create($createPurchaseRequestNoteDTO);

        $purchaseRequestNoteStatusdata = [];
        $purchaseRequestNoteStatusdata['purchase_request_note_id'] = $purchaseRequestNote['id'];
        $purchaseRequestNoteStatusdata['purchase_request_note_status_type_id'] = 1;
        $purchaseRequestNoteStatusdata['notes'] = null;
        $purchaseRequestNoteStatusdata['status_changed_by_id'] = $system_data['created_by'];
        $purchaseRequestNoteStatusdata['is_active'] = true;

        $purchaseRequestNoteStatus = PurchaseRequestNoteStatus::create($purchaseRequestNoteStatusdata);

        // Update purchase_order_status_id
        $updatePurchaseRequestNoteData['purchase_request_note_status_id'] = $purchaseRequestNoteStatus['id'];
        PurchaseRequestNote::where('id', $purchaseRequestNote['id'])->update($updatePurchaseRequestNoteData);
        $updatedPurchaseRequestNote = PurchaseRequestNote::find($purchaseRequestNote['id']);

        return $updatedPurchaseRequestNote;
    }
}
