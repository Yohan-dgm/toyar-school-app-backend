<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\UpdateInitialSection;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\ReceiptVoucherAttachment;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateInitialSectionAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $userDTO = UpdateInitialSectionUserDTO::validate($payloadArray);

        // Data Prep
        $data = [];
        $data['receipt_party'] = $userDTO['receipt_party'];
        if ($data['receipt_party'] == 'Student') {
            $data['student_id'] = $userDTO['student_id'];
            $data['applicant_id'] = null;
            $data['exam_private_candidate_id'] = null;
            $data['private_candidate_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Applicant') {
            $data['applicant_id'] = $userDTO['applicant_id'];
            $data['student_id'] = null;
            $data['exam_private_candidate_id'] = null;
            $data['private_candidate_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Exam Private Candidate') {
            $data['exam_private_candidate_id'] = $userDTO['exam_private_candidate_id'];
            $data['student_id'] = null;
            $data['applicant_id'] = null;
            $data['private_candidate_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Private Candidate') {
            $data['private_candidate_id'] = $userDTO['private_candidate_id'];
            $data['student_id'] = null;
            $data['applicant_id'] = null;
            $data['exam_private_candidate_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Material Bill') {
            $data['material_bill_id'] = $userDTO['material_bill_id'];
            $data['student_id'] = null;
            $data['applicant_id'] = null;
            $data['exam_private_candidate_id'] = null;
            $data['private_candidate_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Admission Fee Invoice') {
            $data['admission_fee_invoice_id'] = $userDTO['admission_fee_invoice_id'];
            $data['student_id'] = null;
            $data['applicant_id'] = null;
            $data['exam_private_candidate_id'] = null;
            $data['private_candidate_id'] = null;
            $data['material_bill_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Term Fee Invoice') {
            $data['term_fee_invoice_id'] = $userDTO['term_fee_invoice_id'];
            $data['student_id'] = null;
            $data['applicant_id'] = null;
            $data['exam_private_candidate_id'] = null;
            $data['private_candidate_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Refundable Deposit') {
            $data['refundable_deposit_id'] = $userDTO['refundable_deposit_id'];
            $data['student_id'] = null;
            $data['applicant_id'] = null;
            $data['exam_private_candidate_id'] = null;
            $data['private_candidate_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
        }
        $data['narration'] = $userDTO['narration'];
        $data['amount'] = $userDTO['amount'];

        $data['admission_fee_settlement'] = ! array_key_exists('admission_fee_settlement', $userDTO) || is_null($userDTO['admission_fee_settlement']) || $userDTO['admission_fee_settlement'] == 'null' ? 0 : $userDTO['admission_fee_settlement'];

        $data['refundable_deposit_settlement'] = ! array_key_exists('refundable_deposit_settlement', $userDTO) || is_null($userDTO['refundable_deposit_settlement']) || $userDTO['refundable_deposit_settlement'] == 'null' ? 0 : $userDTO['refundable_deposit_settlement'];

        $data['term_fee_settlement'] = ! array_key_exists('term_fee_settlement', $userDTO) || is_null($userDTO['term_fee_settlement']) || $userDTO['term_fee_settlement'] == 'null' ? 0 : $userDTO['term_fee_settlement'];

        $data['sport_fee'] = ! array_key_exists('sport_fee', $userDTO) || is_null($userDTO['sport_fee']) || $userDTO['sport_fee'] == 'null' ? 0 : $userDTO['sport_fee'];

        $data['late_fee_charges'] = ! array_key_exists('late_fee_charges', $userDTO) || is_null($userDTO['late_fee_charges']) || $userDTO['late_fee_charges'] == 'null' ? 0 : $userDTO['late_fee_charges'];

        $data['old_bill_number'] = ! array_key_exists('old_bill_number', $userDTO) || is_null($userDTO['old_bill_number']) || $userDTO['old_bill_number'] == 'null' ? null : $userDTO['old_bill_number'];

        $data['payment_method'] = $userDTO['payment_method'];
        if ($data['payment_method'] == 'Bank Deposit') {
            $data['bank_account_id'] = $userDTO['bank_account_id'];
            $data['bank_deposit_date'] = $userDTO['bank_deposit_date'];
            $data['payment_received_date'] = $userDTO['bank_deposit_date'];
            //
            $data['cash_account_id'] = null;
            $data['cash_received_date'] = null;
            //
            $data['check_type'] = null;
            $data['check_bank_id'] = null;
            $data['check_number'] = null;
            $data['check_received_date'] = null;
            $data['check_date'] = null;
        }
        if ($data['payment_method'] == 'Cash') {
            $data['cash_account_id'] = $userDTO['cash_account_id'];
            $data['cash_received_date'] = $userDTO['cash_received_date'];
            $data['payment_received_date'] = $userDTO['cash_received_date'];
            //
            $data['bank_account_id'] = null;
            $data['bank_deposit_date'] = null;
            //
            $data['check_type'] = null;
            $data['check_bank_id'] = null;
            $data['check_number'] = null;
            $data['check_received_date'] = null;
            $data['check_date'] = null;
        }
        if ($data['payment_method'] == 'Check') {
            $data['check_type'] = $userDTO['check_type'];
            $data['check_bank_id'] = $userDTO['check_bank_id'];
            $data['check_number'] = $userDTO['check_number'];
            $data['check_received_date'] = $userDTO['check_received_date'];
            $data['payment_received_date'] = $userDTO['check_received_date'];
            $data['check_date'] = $userDTO['check_date'];
            //
            $data['bank_account_id'] = null;
            $data['bank_deposit_date'] = null;
            //
            $data['cash_account_id'] = null;
            $data['cash_received_date'] = null;
        }
        if ($userDTO['receipt_voucher_type'] == 'General') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        } elseif ($userDTO['receipt_voucher_type'] == 'Exam Bill') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['exam_bill_id'] = $userDTO['exam_bill_id'];
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        } elseif ($userDTO['receipt_voucher_type'] == 'Material Bill') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['material_bill_id'] = $userDTO['material_bill_id'];
            $data['exam_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        } elseif ($userDTO['receipt_voucher_type'] == 'Admission Fee Invoice') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['admission_fee_invoice_id'] = $userDTO['admission_fee_invoice_id'];
            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        } elseif ($userDTO['receipt_voucher_type'] == 'Term Fee Invoice') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['term_fee_invoice_id'] = $userDTO['term_fee_invoice_id'];
            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
        } elseif ($userDTO['receipt_voucher_type'] == 'Refundable Deposit') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['refundable_deposit_id'] = $userDTO['refundable_deposit_id'];
            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
        }

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];
        $system_data['receipt_voucher_status_type_id'] = 1;

        // Final Data Validation
        $updateInitialSectionDTO = UpdateInitialSectionDTO::validate(array_merge($data, $system_data));

        // Save In Database
        ReceiptVoucher::where('id', $userDTO['id'])->update($updateInitialSectionDTO);

        $receiptVoucher = ReceiptVoucher::find($userDTO['id']);

        // Updade Saved Attachments
        if (is_null($actionData['receipt_voucher_attachment_list']) && count($receiptVoucher->receipt_voucher_attachment_list) > 0) {
            $persistedAttachmentList = $receiptVoucher->receipt_voucher_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = $persistedFileNameList;
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    ReceiptVoucherAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/account-management/receipt-voucher/$receiptVoucher->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }
        if (! is_null($actionData['receipt_voucher_attachment_list']) && count($actionData['receipt_voucher_attachment_list']) > 0 && count($receiptVoucher->receipt_voucher_attachment_list) > 0) {
            $persistedAttachmentList = $receiptVoucher->receipt_voucher_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = array_merge(array_diff($persistedFileNameList, $actionData['receipt_voucher_attachment_list']), array_diff($actionData['receipt_voucher_attachment_list'], $persistedFileNameList));
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    ReceiptVoucherAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/account-management/receipt-voucher/$receiptVoucher->serial_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }

        // Create Unsaved Attachments
        if (! is_null($actionData['receipt_voucher_unsaved_attachment_list']) && count($actionData['receipt_voucher_unsaved_attachment_list']) > 0) {
            foreach ($actionData['receipt_voucher_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/account-management/receipt-voucher/$receiptVoucher->serial_number_digits/";
                $data = [];
                $data['receipt_voucher_id'] = $receiptVoucher->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($receiptVoucher->serial_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $receiptVoucherAttachment = ReceiptVoucherAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/account-management/receipt-voucher/$receiptVoucher->serial_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        $receiptVoucher = ReceiptVoucher::where('id', $receiptVoucher->id)->with('exam_bill')->with('material_bill')->first();

        if ($userDTO['material_bill_id'] != null && $userDTO['material_bill_id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('material_bill_id', $userDTO['material_bill_id'])->sum('amount');
            $materialBillSum = MaterialBill::where('id', $userDTO['material_bill_id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $materialBillSum->bill_total) {
                MaterialBill::where('id', $userDTO['material_bill_id'])->update(['is_material_bill_complete' => true]);
            } else {
                MaterialBill::where('id', $userDTO['material_bill_id'])->update(['is_material_bill_complete' => false]);
            }
        }
        // create invoice log
        $logData['description'] = '[STATUS: Updated Receipt Voucher, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$receiptVoucher->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Receipt Voucher';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['user_id']]);

        return $receiptVoucher;
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
