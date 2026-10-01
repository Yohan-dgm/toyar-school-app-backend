<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNote\CreateServicesReceivedNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\CreateServicesReceivedNoteItem\CreateServicesReceivedNoteItemAction;
use Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\CreateServicesReceivedNoteItem\CreateServicesReceivedNoteItemUserDTO;
use Modules\PurchasingManagement\Models\ServicesReceivedNote;
use Modules\PurchasingManagement\Models\ServicesReceivedNoteAttachment;

class CreateServicesReceivedNoteAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createServicesReceivedNoteUserDTO = CreateServicesReceivedNoteUserDTO::validate($payloadArray);

        $createServicesReceivedNoteUserDTO['reference_number'] = is_null($createServicesReceivedNoteUserDTO['reference_number'] == 'null') || $createServicesReceivedNoteUserDTO['reference_number'] == 'null' ? null : $createServicesReceivedNoteUserDTO['reference_number'];
        $createServicesReceivedNoteUserDTO['office_notes'] = is_null($createServicesReceivedNoteUserDTO['office_notes'] == 'null') || $createServicesReceivedNoteUserDTO['office_notes'] == 'null' ? null : $createServicesReceivedNoteUserDTO['office_notes'];

        $system_data['serial_number_prefix'] = 'NY/SRN';
        $maxDigits = ServicesReceivedNote::where(function (Builder $receipt_query) {
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
        $system_data['created_by'] = $actionData['user_id'];

        $createServicesReceivedNoteSystemDTO = CreateServicesReceivedNoteSystemDTO::validate($system_data);
        $createServicesReceivedNoteDTO = CreateServicesReceivedNoteDTO::validate(array_merge($createServicesReceivedNoteUserDTO, $createServicesReceivedNoteSystemDTO));
        $createdServicesReceivedNote = ServicesReceivedNote::create($createServicesReceivedNoteDTO);
        // Create Unsaved Attachments
        if (! is_null($actionData['services_received_note_unsaved_attachment_list']) && count($actionData['services_received_note_unsaved_attachment_list']) > 0) {
            foreach ($actionData['services_received_note_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/purchasing-management/services-received-note/$createdServicesReceivedNote->serial_number_digits/";
                $data = [];
                $data['services_received_note_id'] = $createdServicesReceivedNote->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($createdServicesReceivedNote->serial_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $servicesReceivedNoteAttachment = ServicesReceivedNoteAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/purchasing-management/services-received-note/$createdServicesReceivedNote->serial_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        // GRN Items
        $servicesReceivedNoteItemList = $actionData['services_received_note_item_list'] ?? [];
        foreach ($servicesReceivedNoteItemList as $item) {
            $item = json_decode($item, true);
            $item['services_received_note_id'] = $createdServicesReceivedNote->id;
            $createServicesReceivedNoteItemUserDTO = CreateServicesReceivedNoteItemUserDTO::validate($item);
            $servicesReceivedNoteItemActionData = [
                'purchase_order_id' => $createServicesReceivedNoteUserDTO['purchase_order_id'],
                'user_id' => $actionData['user_id'],
            ];
            CreateServicesReceivedNoteItemAction::run($createServicesReceivedNoteItemUserDTO, $servicesReceivedNoteItemActionData);
        }

        $createdServicesReceivedNote = ServicesReceivedNote::with(['services_received_note_item_list' => function (Builder $services_received_note_item_list_query) {
            //
            $services_received_note_item_list_query->with(['purchase_order_item' => function (Builder $purchase_order_item_query) {
                //
                $purchase_order_item_query->with(['material_item' => function (Builder $material_item_query) {
                    //
                    $material_item_query->with(['material_item_type' => function (Builder $material_item_type_query) {
                        //
                        $material_item_type_query->select('*');
                    }])->with(['material_item_category' => function (Builder $material_item_category_query) {
                        //
                        $material_item_category_query->select('*');
                    }])->with(['unit' => function (Builder $unit_query) {
                        //
                        $unit_query->select('*');
                    }])->select('*');
                }])->select('*');
            }])->select('*');
        }])->with(['purchase_order' => function (Builder $purchase_order_query) {
            //
            $purchase_order_query->with(['supplier' => function (Builder $supplier_query) {
                //
                $supplier_query->select('id', 'name', 'serial_number');
            }])->select('*');
        }])->select('*')->find($createdServicesReceivedNote->id);

        return $createdServicesReceivedNote;
    }

    public function getUniqueFileName($prefix, $path, $extension)
    {
        $count = 1;
        $file = '';
        if (is_null($extension)) {
            $extension = '';
        }
        do {
            if ($count == 1) {
                $file = $prefix.'-'.microtime(true).'.'.$extension;
                $count++;
            } else {
                $file = $prefix.'-'.microtime(true).'_'.$count.'.'.$extension;
                $count++;
            }
        } while (file_exists($path.$file));

        return $file;
    }
}
