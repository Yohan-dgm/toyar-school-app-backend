<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNote\UpdateServicesReceivedNote;

use Illuminate\Support\Facades\Storage;
use Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\CreateServicesReceivedNoteItem\CreateServicesReceivedNoteItemAction;
use Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\CreateServicesReceivedNoteItem\CreateServicesReceivedNoteItemUserDTO;
use Modules\PurchasingManagement\Models\ServicesReceivedNote;
use Modules\PurchasingManagement\Models\ServicesReceivedNoteAttachment;

class UpdateServicesReceivedNoteAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateServicesReceivedNoteUserDTO = UpdateServicesReceivedNoteUserDTO::validate($payloadArray);

        $updateServicesReceivedNoteUserDTO['reference_number'] = is_null($updateServicesReceivedNoteUserDTO['reference_number'] == 'null') || $updateServicesReceivedNoteUserDTO['reference_number'] == 'null' ? null : $updateServicesReceivedNoteUserDTO['reference_number'];
        $updateServicesReceivedNoteUserDTO['office_notes'] = is_null($updateServicesReceivedNoteUserDTO['office_notes'] == 'null') || $updateServicesReceivedNoteUserDTO['office_notes'] == 'null' ? null : $updateServicesReceivedNoteUserDTO['office_notes'];

        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        $updateServicesReceivedNoteSystemDTO = UpdateServicesReceivedNoteSystemDTO::validate($system_data);
        $updateServicesReceivedNoteDTO = UpdateServicesReceivedNoteDTO::validate(array_merge($updateServicesReceivedNoteUserDTO, $updateServicesReceivedNoteSystemDTO));
        ServicesReceivedNote::where('id', $updateServicesReceivedNoteUserDTO['id'])->update($updateServicesReceivedNoteDTO);

        // delete existing bill items
        ServicesReceivedNote::where('id', $updateServicesReceivedNoteUserDTO['id'])->first()->services_received_note_item_list()->delete();
        // create new bill items
        $servicesReceivedNoteItemList = $actionData['services_received_note_item_list'] ?? [];
        foreach ($servicesReceivedNoteItemList as $item) {
            $item = json_decode($item, true);
            $item['services_received_note_id'] = $updateServicesReceivedNoteUserDTO['id'];
            $createServicesReceivedNoteItemUserDTO = CreateServicesReceivedNoteItemUserDTO::validate($item);
            $servicesReceivedNoteItemActionData = [
                'purchase_order_id' => $updateServicesReceivedNoteUserDTO['purchase_order_id'],
                'user_id' => $actionData['user_id'],
            ];
            CreateServicesReceivedNoteItemAction::run($createServicesReceivedNoteItemUserDTO, $servicesReceivedNoteItemActionData);
        }

        $updatedServicesReceivedNote = ServicesReceivedNote::find($updateServicesReceivedNoteUserDTO['id']);

        // Updade Saved Attachments
        if (is_null($actionData['services_received_note_attachment_list']) && count($updatedServicesReceivedNote->services_received_note_attachment_list) > 0) {
            $persistedAttachmentList = $updatedServicesReceivedNote->services_received_note_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = $persistedFileNameList;
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    ServicesReceivedNoteAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/purchasing-management/services-received-note/$updatedServicesReceivedNote->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }
        if (! is_null($actionData['services_received_note_attachment_list']) && count($actionData['services_received_note_attachment_list']) > 0 && count($updatedServicesReceivedNote->services_received_note_attachment_list) > 0) {
            $persistedAttachmentList = $updatedServicesReceivedNote->services_received_note_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = array_merge(array_diff($persistedFileNameList, $actionData['services_received_note_attachment_list']), array_diff($actionData['services_received_note_attachment_list'], $persistedFileNameList));
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    ServicesReceivedNoteAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/purchasing-management/services-received-note/$updatedServicesReceivedNote->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }

        // Create Unsaved Attachments
        if (! is_null($actionData['services_received_note_unsaved_attachment_list']) && count($actionData['services_received_note_unsaved_attachment_list']) > 0) {
            foreach ($actionData['services_received_note_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/purchasing-management/services-received-note/$updatedServicesReceivedNote->serial_number_digits/";
                $data = [];
                $data['services_received_note_id'] = $updatedServicesReceivedNote->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($updatedServicesReceivedNote->serial_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $servicesReceivedNoteAttachment = ServicesReceivedNoteAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/purchasing-management/services-received-note/$updatedServicesReceivedNote->serial_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        return $updatedServicesReceivedNote;
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
