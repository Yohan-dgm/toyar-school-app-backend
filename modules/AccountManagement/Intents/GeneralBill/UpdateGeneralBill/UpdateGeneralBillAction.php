<?php

namespace Modules\AccountManagement\Intents\GeneralBill\UpdateGeneralBill;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\GeneralBill;
use Modules\AccountManagement\Models\GeneralBillAttachment;

class UpdateGeneralBillAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateGeneralBillUserDTO = UpdateGeneralBillUserDTO::validate($payloadArray);

        // Data Prep
        $updateGeneralBillUserDTO['approved_admission_fee'] = ! array_key_exists('approved_admission_fee', $updateGeneralBillUserDTO) || is_null($updateGeneralBillUserDTO['approved_admission_fee']) || $updateGeneralBillUserDTO['approved_admission_fee'] == 'null' ? 0 : $updateGeneralBillUserDTO['approved_admission_fee'];

        $updateGeneralBillUserDTO['applicable_refundable_deposit'] = ! array_key_exists('applicable_refundable_deposit', $updateGeneralBillUserDTO) || is_null($updateGeneralBillUserDTO['applicable_refundable_deposit']) || $updateGeneralBillUserDTO['applicable_refundable_deposit'] == 'null' ? 0 : $updateGeneralBillUserDTO['applicable_refundable_deposit'];

        $updateGeneralBillUserDTO['applicable_term_payment'] = ! array_key_exists('applicable_term_payment', $updateGeneralBillUserDTO) || is_null($updateGeneralBillUserDTO['applicable_term_payment']) || $updateGeneralBillUserDTO['applicable_term_payment'] == 'null' ? 0 : $updateGeneralBillUserDTO['applicable_term_payment'];

        // System Data Prep
        $system_data = [];
        if ($updateGeneralBillUserDTO['gender'] == 'Male') {
            $full_name_with_title = 'Master. '.$updateGeneralBillUserDTO['full_name'];
        } elseif ($updateGeneralBillUserDTO['gender'] == 'Female') {
            $full_name_with_title = 'Miss. '.$updateGeneralBillUserDTO['full_name'];
        }
        $system_data = [
            'updated_by' => $actionData['user_id'],
            'full_name_with_title' => $full_name_with_title,
        ];

        // System Data Validation
        $updateGeneralBillSystemDTO = UpdateGeneralBillSystemDTO::validate($system_data);
        // Final Data Validation
        $updateGeneralBillDTO = UpdateGeneralBillDTO::validate(array_merge($updateGeneralBillUserDTO, $updateGeneralBillSystemDTO));

        // if (array_key_exists('school_house_id', $updateGeneralBillDTO) && $updateGeneralBillDTO['school_house_id'] == "null") {
        //     unset($updateGeneralBillDTO["school_house_id"]);
        // }
        // Save In Database
        GeneralBill::where('id', $updateGeneralBillUserDTO['id'])->update($updateGeneralBillDTO);

        $general_bill = GeneralBill::find($updateGeneralBillUserDTO['id']);

        // Updade Saved Attachments
        if (is_null($actionData['general_bill_attachment_list']) && count($general_bill->general_bill_attachment_list) > 0) {
            $persistedAttachmentList = $general_bill->general_bill_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = $persistedFileNameList;
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    GeneralBillAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/general_bill-management/general_bill/$general_bill->admission_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }
        if (! is_null($actionData['general_bill_attachment_list']) && count($actionData['general_bill_attachment_list']) > 0 && count($general_bill->general_bill_attachment_list) > 0) {
            $persistedAttachmentList = $general_bill->general_bill_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = array_merge(array_diff($persistedFileNameList, $actionData['general_bill_attachment_list']), array_diff($actionData['general_bill_attachment_list'], $persistedFileNameList));
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    GeneralBillAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/general_bill-management/general_bill/$general_bill->admission_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }

        // Create Unsaved Attachments
        if (! is_null($actionData['general_bill_unsaved_attachment_list']) && count($actionData['general_bill_unsaved_attachment_list']) > 0) {
            foreach ($actionData['general_bill_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/general_bill-management/general_bill/$general_bill->admission_number_digits/";
                $data = [];
                $data['general_bill_id'] = $general_bill->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($general_bill->admission_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $general_billAttachment = GeneralBillAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/general_bill-management/general_bill/$general_bill->admission_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        return $general_bill;
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
