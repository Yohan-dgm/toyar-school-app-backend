<?php

namespace Modules\AccountManagement\Intents\SupplierBill\UpdateSupplierBill;

use Illuminate\Support\Facades\Storage;
use Modules\AccountManagement\Intents\SupplierBillItem\CreateSupplierBillItem\CreateSupplierBillItemAction;
use Modules\AccountManagement\Intents\SupplierBillItem\CreateSupplierBillItem\CreateSupplierBillItemUserDTO;
use Modules\AccountManagement\Models\SupplierBill;
use Modules\AccountManagement\Models\SupplierBillAttachment;

class UpdateSupplierBillAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateSupplierBillUserDTO = UpdateSupplierBillUserDTO::validate($payloadArray);

        $updateSupplierBillUserDTO['items_total'] = is_null($updateSupplierBillUserDTO['items_total'] == 'null') || $updateSupplierBillUserDTO['items_total'] == 'null' ? 0 : $updateSupplierBillUserDTO['items_total'];
        $updateSupplierBillUserDTO['transport_charges_total'] = is_null($updateSupplierBillUserDTO['transport_charges_total'] == 'null') || $updateSupplierBillUserDTO['transport_charges_total'] == 'null' ? 0 : $updateSupplierBillUserDTO['transport_charges_total'];
        $updateSupplierBillUserDTO['service_charges_total'] = is_null($updateSupplierBillUserDTO['service_charges_total'] == 'null') || $updateSupplierBillUserDTO['service_charges_total'] == 'null' ? 0 : $updateSupplierBillUserDTO['service_charges_total'];
        $updateSupplierBillUserDTO['subtotal_before_discount'] = is_null($updateSupplierBillUserDTO['subtotal_before_discount'] == 'null') || $updateSupplierBillUserDTO['subtotal_before_discount'] == 'null' ? 0 : $updateSupplierBillUserDTO['subtotal_before_discount'];
        $updateSupplierBillUserDTO['discount_total'] = is_null($updateSupplierBillUserDTO['discount_total'] == 'null') || $updateSupplierBillUserDTO['discount_total'] == 'null' ? 0 : $updateSupplierBillUserDTO['discount_total'];
        $updateSupplierBillUserDTO['subtotal_after_discount'] = is_null($updateSupplierBillUserDTO['subtotal_after_discount'] == 'null') || $updateSupplierBillUserDTO['subtotal_after_discount'] == 'null' ? 0 : $updateSupplierBillUserDTO['subtotal_after_discount'];
        $updateSupplierBillUserDTO['tax_total'] = is_null($updateSupplierBillUserDTO['tax_total'] == 'null') || $updateSupplierBillUserDTO['tax_total'] == 'null' ? 0 : $updateSupplierBillUserDTO['tax_total'];
        $updateSupplierBillUserDTO['bill_total'] = is_null($updateSupplierBillUserDTO['bill_total'] == 'null') || $updateSupplierBillUserDTO['bill_total'] == 'null' ? 0 : $updateSupplierBillUserDTO['bill_total'];

        $updateSupplierBillUserDTO['office_notes'] = is_null($updateSupplierBillUserDTO['office_notes'] == 'null') || $updateSupplierBillUserDTO['office_notes'] == 'null' ? null : $updateSupplierBillUserDTO['office_notes'];

        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        $updateSupplierBillSystemDTO = UpdateSupplierBillSystemDTO::validate($system_data);
        $updateSupplierBillDTO = UpdateSupplierBillDTO::validate(array_merge($updateSupplierBillUserDTO, $updateSupplierBillSystemDTO));
        SupplierBill::where('id', $updateSupplierBillUserDTO['id'])->update($updateSupplierBillDTO);

        // delete existing bill items
        SupplierBill::where('id', $updateSupplierBillUserDTO['id'])->first()->supplier_bill_item_list()->delete();
        // create new bill items
        $supplierBillItemList = $actionData['supplier_bill_item_list'] ?? [];
        foreach ($supplierBillItemList as $item) {
            $item = json_decode($item, true);
            $item['supplier_bill_id'] = $updateSupplierBillUserDTO['id'];
            $createSupplierBillItemUserDTO = CreateSupplierBillItemUserDTO::validate($item);
            $supplierBillItemActionData = [
                'purchase_order_id' => $updateSupplierBillUserDTO['purchase_order_id'],
                'user_id' => $actionData['user_id'],
            ];
            CreateSupplierBillItemAction::run($createSupplierBillItemUserDTO, $supplierBillItemActionData);
        }

        $updatedSupplierBill = SupplierBill::find($updateSupplierBillUserDTO['id']);

        // Updade Saved Attachments
        if (is_null($actionData['supplier_bill_attachment_list']) && count($updatedSupplierBill->supplier_bill_attachment_list) > 0) {
            $persistedAttachmentList = $updatedSupplierBill->supplier_bill_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = $persistedFileNameList;
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    SupplierBillAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/account-management/supplier-bill/$updatedSupplierBill->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }
        if (! is_null($actionData['supplier_bill_attachment_list']) && count($actionData['supplier_bill_attachment_list']) > 0 && count($updatedSupplierBill->supplier_bill_attachment_list) > 0) {
            $persistedAttachmentList = $updatedSupplierBill->supplier_bill_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = array_merge(array_diff($persistedFileNameList, $actionData['supplier_bill_attachment_list']), array_diff($actionData['supplier_bill_attachment_list'], $persistedFileNameList));
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    SupplierBillAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/account-management/supplier-bill/$updatedSupplierBill->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }

        // Create Unsaved Attachments
        if (! is_null($actionData['supplier_bill_unsaved_attachment_list']) && count($actionData['supplier_bill_unsaved_attachment_list']) > 0) {
            foreach ($actionData['supplier_bill_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/account-management/supplier-bill/$updatedSupplierBill->serial_number_digits/";
                $data = [];
                $data['supplier_bill_id'] = $updatedSupplierBill->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($updatedSupplierBill->serial_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $supplierBillAttachment = SupplierBillAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/account-management/supplier-bill/$updatedSupplierBill->serial_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        return $updatedSupplierBill;
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
