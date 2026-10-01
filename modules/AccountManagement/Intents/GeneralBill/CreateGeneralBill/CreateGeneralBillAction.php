<?php

namespace Modules\AccountManagement\Intents\GeneralBill\CreateGeneralBill;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\GeneralBill;
use Modules\AccountManagement\Models\GeneralBillAttachment;

class CreateGeneralBillAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createGeneralBillUserDTO = CreateGeneralBillUserDTO::validate($payloadArray);

        // Data Prep
        $createGeneralBillUserDTO['approved_admission_fee'] = ! array_key_exists('approved_admission_fee', $createGeneralBillUserDTO) || is_null($createGeneralBillUserDTO['approved_admission_fee']) || $createGeneralBillUserDTO['approved_admission_fee'] == 'null' ? 0 : $createGeneralBillUserDTO['approved_admission_fee'];

        $createGeneralBillUserDTO['applicable_refundable_deposit'] = ! array_key_exists('applicable_refundable_deposit', $createGeneralBillUserDTO) || is_null($createGeneralBillUserDTO['applicable_refundable_deposit']) || $createGeneralBillUserDTO['applicable_refundable_deposit'] == 'null' ? 0 : $createGeneralBillUserDTO['applicable_refundable_deposit'];

        $createGeneralBillUserDTO['applicable_term_payment'] = ! array_key_exists('applicable_term_payment', $createGeneralBillUserDTO) || is_null($createGeneralBillUserDTO['applicable_term_payment']) || $createGeneralBillUserDTO['applicable_term_payment'] == 'null' ? 0 : $createGeneralBillUserDTO['applicable_term_payment'];

        // System Data Prep
        $admissionNumberDigits = GeneralBill::where(function (Builder $admission_query) {})->max('admission_number_digits');

        $admission_number_digits = (int) $admissionNumberDigits + 1;
        $admission_number_current_year = strval(date('m') > 8 ? date('y') : (date('y') - 1));
        $admission_number_prefix = 'NY';
        $admission_number = $admission_number_prefix.$admission_number_current_year.'/'.$admission_number_digits;

        if ($createGeneralBillUserDTO['gender'] == 'Male') {
            $full_name_with_title = 'Master. '.$createGeneralBillUserDTO['full_name'];
        } elseif ($createGeneralBillUserDTO['gender'] == 'Female') {
            $full_name_with_title = 'Miss. '.$createGeneralBillUserDTO['full_name'];
        }
        $system_data = [
            'admission_number_digits' => $admission_number_digits,
            'admission_number_current_year' => $admission_number_current_year,
            'admission_number_prefix' => $admission_number_prefix,
            'admission_number' => $admission_number,
            'created_by' => $actionData['user_id'],
            'full_name_with_title' => $full_name_with_title,
            'joined_date' => date('Y-m-d'),
        ];

        // System Data Validation
        $createGeneralBillSystemDTO = CreateGeneralBillSystemDTO::validate($system_data);
        // Final Data Validation
        $createGeneralBillDTO = CreateGeneralBillDTO::validate(array_merge($createGeneralBillUserDTO, $createGeneralBillSystemDTO));

        // if (array_key_exists('school_house_id', $createGeneralBillDTO) && $createGeneralBillDTO['school_house_id'] == "null") {
        //     unset($createGeneralBillDTO["school_house_id"]);
        // }
        // Save In Database
        $general_bill = GeneralBill::create($createGeneralBillDTO);

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
