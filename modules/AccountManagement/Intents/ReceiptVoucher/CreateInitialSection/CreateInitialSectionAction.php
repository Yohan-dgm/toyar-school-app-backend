<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\CreateInitialSection;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\ApplicantProformaInvoice;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\ReceiptVoucherAttachment;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\TermFeePayment;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateInitialSectionAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $userDTO = CreateInitialSectionUserDTO::validate($payloadArray);

        // Data Prep
        $data = [];
        $data['receipt_party'] = $userDTO['receipt_party'];

        // $data['student_id'] = null;
        // $data['applicant_id'] = null;
        // $data['exam_private_candidate_id'] = null;
        // $data['private_candidate_id'] = null;
        // $data['material_bill_id'] = null;
        // $data['admission_fee_invoice_id'] = null;
        // $data['term_fee_invoice_id'] = null;
        // $data['refundable_deposit_id'] = null;
        // $data['sport_fee_invoice_id'] = null;
        // $data['applicant_proforma_invoice_id'] = null;

        if ($data['receipt_party'] == 'Student') {
            $data['student_id'] = $userDTO['student_id'];
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
            $data['admission_fee_invoice_id'] = $userDTO['admission_fee_invoice_id'];
            $data['term_fee_invoice_id'] = $userDTO['term_fee_invoice_id'];
            $data['refundable_deposit_id'] = $userDTO['refundable_deposit_id'];
            $data['sport_fee_invoice_id'] = $userDTO['sport_fee_invoice_id'];
        }

        if ($data['receipt_party'] == 'Applicant') {
            $data['applicant_id'] = $userDTO['applicant_id'];
            // $data['student_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
            // $data['sport_fee_invoice_id'] = null;
        }
        if ($data['receipt_party'] == 'Exam Private Candidate') {
            $data['exam_private_candidate_id'] = $userDTO['exam_private_candidate_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
            // $data['sport_fee_invoice_id'] = null;
        }
        if ($data['receipt_party'] == 'Private Candidate') {
            $data['private_candidate_id'] = $userDTO['private_candidate_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
            // $data['sport_fee_invoice_id'] = null;
        }
        if ($data['receipt_party'] == 'Material Bill') {
            $data['material_bill_id'] = $userDTO['material_bill_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
            // $data['sport_fee_invoice_id'] = null;
        }
        if ($data['receipt_party'] == 'Admission Fee Invoice') {
            $data['admission_fee_invoice_id'] = $userDTO['admission_fee_invoice_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
            // $data['sport_fee_invoice_id'] = null;
        }
        if ($data['receipt_party'] == 'Term Fee Invoice') {
            $data['term_fee_invoice_id'] = $userDTO['term_fee_invoice_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
            // $data['sport_fee_invoice_id'] = null;
        }
        if ($data['receipt_party'] == 'Refundable Deposit') {
            $data['refundable_deposit_id'] = $userDTO['refundable_deposit_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['sport_fee_invoice_id'] = null;
        }
        if ($data['receipt_party'] == 'Sport Fee Invoice') {
            $data['sport_fee_invoice_id'] = $userDTO['sport_fee_invoice_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
        }
        if ($data['receipt_party'] == 'Applicant Proforma Invoice') {
            $data['applicant_proforma_invoice_id'] = $userDTO['applicant_proforma_invoice_id'];
            // $data['student_id'] = null;
            // $data['applicant_id'] = null;
            // $data['exam_private_candidate_id'] = null;
            // $data['private_candidate_id'] = null;
            // $data['material_bill_id'] = null;
            // $data['admission_fee_invoice_id'] = null;
            // $data['term_fee_invoice_id'] = null;
            // $data['refundable_deposit_id'] = null;
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

        // $data['exam_bill_id'] = null;
        // $data['material_bill_id'] = null;
        $data['admission_fee_invoice_id'] = null;
        $data['term_fee_invoice_id'] = null;
        $data['refundable_deposit_id'] = null;
        $data['sport_fee_invoice_id'] = null;
        $data['applicant_proforma_invoice_id'] = null;
        // $data['receipt_voucher_type'] = null;

        if ($userDTO['receipt_voucher_type'] == 'General') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            if (is_numeric($userDTO['term_fee_invoice_id'])) {
                $data['term_fee_invoice_id'] = $userDTO['term_fee_invoice_id'];
            }
            if (is_numeric($userDTO['refundable_deposit_id'])) {
                $data['refundable_deposit_id'] = $userDTO['refundable_deposit_id'];
            }
            if (is_numeric($userDTO['admission_fee_invoice_id'])) {
                $data['admission_fee_invoice_id'] = $userDTO['admission_fee_invoice_id'];
            }
            if (is_numeric($userDTO['sport_fee_invoice_id'])) {
                $data['sport_fee_invoice_id'] = $userDTO['sport_fee_invoice_id'];
            }
            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            //
        } elseif ($userDTO['receipt_voucher_type'] == 'Exam Bill') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['exam_bill_id'] = $userDTO['exam_bill_id'];

            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
            $data['sport_fee_invoice_id'] = null;
            $data['applicant_proforma_invoice_id'] = null;

            //
        } elseif ($userDTO['receipt_voucher_type'] == 'Material Bill') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['material_bill_id'] = $userDTO['material_bill_id'];

            $data['exam_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
            $data['sport_fee_invoice_id'] = null;
            $data['applicant_proforma_invoice_id'] = null;
            //
        } elseif ($userDTO['receipt_voucher_type'] == 'Admission Fee Invoice') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['admission_fee_invoice_id'] = $userDTO['admission_fee_invoice_id'];
            // $data['admission_fee_settlement'] = $userDTO['amount'];

            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
            $data['sport_fee_invoice_id'] = null;
            $data['applicant_proforma_invoice_id'] = null;
            //
        } elseif ($userDTO['receipt_voucher_type'] == 'Term Fee Invoice') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['term_fee_invoice_id'] = $userDTO['term_fee_invoice_id'];
            // $data['term_fee_settlement'] = $userDTO['amount'];

            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
            $data['sport_fee_invoice_id'] = null;
            $data['applicant_proforma_invoice_id'] = null;
            //
        } elseif ($userDTO['receipt_voucher_type'] == 'Refundable Deposit') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['refundable_deposit_id'] = $userDTO['refundable_deposit_id'];
            // $data['refundable_deposit_settlement'] = $userDTO['amount'];

            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['sport_fee_invoice_id'] = null;
            $data['applicant_proforma_invoice_id'] = null;
            //
        } elseif ($userDTO['receipt_voucher_type'] == 'Sport Fee Invoice') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['sport_fee_invoice_id'] = $userDTO['sport_fee_invoice_id'];
            // $data['sport_fee'] = $userDTO['amount'];

            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
            $data['applicant_proforma_invoice_id'] = null;
            //
        } elseif ($userDTO['receipt_voucher_type'] == 'Applicant Proforma Invoice') {
            $data['receipt_voucher_type'] = $userDTO['receipt_voucher_type'];
            $data['applicant_proforma_invoice_id'] = $userDTO['applicant_proforma_invoice_id'];

            $data['exam_bill_id'] = null;
            $data['material_bill_id'] = null;
            $data['admission_fee_invoice_id'] = null;
            $data['term_fee_invoice_id'] = null;
            $data['refundable_deposit_id'] = null;
            $data['sport_fee_invoice_id'] = null;
            //
        }
        $data['payment_received_by_id'] = $actionData['user_id'];
        $data['is_active'] = true;
        $data['is_deleted_reqested'] = false;

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];
        $system_data['receipt_voucher_status_type_id'] = 1;
        $system_data['serial_number_prefix'] = 'NY/REC';

        $maxDigits = ReceiptVoucher::where(function (Builder $receipt_query) {
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

        // Final Data Validation
        $createInitialSectionDTO = CreateInitialSectionDTO::validate(array_merge($data, $system_data));

        // Save In Database
        // var_dump($createInitialSectionDTO);
        $receiptVoucher = ReceiptVoucher::create($createInitialSectionDTO);

        //update payment complete
        // if ($userDTO['receipt_voucher_type'] == "Sport Fee Invoice") {

        if ($userDTO['receipt_voucher_type'] == 'Term Fee Invoice') {
            $termFeeInvoice = TermFeeInvoice::where('id', $userDTO['term_fee_invoice_id'])->first();

            $termFeePaymentData['term_fee_invoice_id'] = $userDTO['term_fee_invoice_id'];
            $termFeePaymentData['term_id'] = $termFeeInvoice->term_id;
            $termFeePaymentData['student_id'] = $termFeeInvoice->student_id;
            $termFeePaymentData['receipt_voucher_id'] = $receiptVoucher->id;
            $termFeePaymentData['paid_amount'] = $userDTO['term_fee_settlement'];
            TermFeePayment::create($termFeePaymentData);

            $termFeeInvoiceComplete = TermFeeInvoice::get();
            foreach ($termFeeInvoiceComplete as $termFeeInvoiceCompleteData) {
                $reciptVoucher = TermFeePayment::where('term_fee_invoice_id', $termFeeInvoiceCompleteData->id)->sum('paid_amount');
                if ($termFeeInvoiceCompleteData->bill_total - $reciptVoucher == 10 || $termFeeInvoiceCompleteData->bill_total - $reciptVoucher < 10) {
                    TermFeeInvoice::where('id', $termFeeInvoiceCompleteData->id)->update(['is_term_fee_invoice_complete' => true]);
                }
                // else {
                //     TermFeeInvoice::where('id', $termFeeInvoiceData->id)->update(['is_term_fee_invoice_complete' => false]);
                // }
            }
        }
        // dd($userDTO['sport_fee_invoice_id']);
        if ($userDTO['sport_fee_invoice_id'] != null && $userDTO['sport_fee_invoice_id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('sport_fee_invoice_id', $userDTO['sport_fee_invoice_id'])->sum('sport_fee');
            $sportFeeInvoiceSum = SportFeeInvoice::where('id', $userDTO['sport_fee_invoice_id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $sportFeeInvoiceSum->bill_total) {
                SportFeeInvoice::where('id', $userDTO['sport_fee_invoice_id'])->update(['is_sport_fee_invoice_complete' => true]);
            }
        }
        if ($userDTO['refundable_deposit_id'] != null && $userDTO['refundable_deposit_id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('refundable_deposit_id', $userDTO['refundable_deposit_id'])->sum('refundable_deposit_settlement');
            $refundableDepositInvoiceSum = RefundableDeposit::where('id', $userDTO['refundable_deposit_id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $refundableDepositInvoiceSum->bill_total) {
                RefundableDeposit::where('id', $userDTO['refundable_deposit_id'])->update(['is_refundable_deposit_complete' => true]);
            }
        }
        if ($userDTO['admission_fee_invoice_id'] != null && $userDTO['admission_fee_invoice_id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('admission_fee_invoice_id', $userDTO['admission_fee_invoice_id'])->sum('admission_fee_settlement');
            $admissionFeeInvoiceSum = AdmissionFeeInvoice::where('id', $userDTO['admission_fee_invoice_id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $admissionFeeInvoiceSum->bill_total) {
                AdmissionFeeInvoice::where('id', $userDTO['admission_fee_invoice_id'])->update(['is_admission_fee_invoice_complete' => true]);
            }
        }
        if ($userDTO['material_bill_id'] != null && $userDTO['material_bill_id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('material_bill_id', $userDTO['material_bill_id'])->sum('amount');
            $materialBillSum = MaterialBill::where('id', $userDTO['material_bill_id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $materialBillSum->bill_total) {
                MaterialBill::where('id', $userDTO['material_bill_id'])->update(['is_material_bill_complete' => true]);
            } else {
                MaterialBill::where('id', $userDTO['material_bill_id'])->update(['is_material_bill_complete' => false]);
            }
        }
        if ($userDTO['applicant_proforma_invoice_id'] != null && $userDTO['applicant_proforma_invoice_id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('applicant_proforma_invoice_id', $userDTO['applicant_proforma_invoice_id'])->sum('amount');
            $materialBillSum = ApplicantProformaInvoice::where('id', $userDTO['applicant_proforma_invoice_id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $materialBillSum->bill_total) {
                ApplicantProformaInvoice::where('id', $userDTO['applicant_proforma_invoice_id'])->update(['is_applicant_proforma_invoice_complete' => true]);
            } else {
                ApplicantProformaInvoice::where('id', $userDTO['applicant_proforma_invoice_id'])->update(['is_applicant_proforma_invoice_complete' => false]);
            }
        }

        // }
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

        // create invoice log
        $logData['description'] = '[STATUS: Created Receipt Voucher, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$receiptVoucher->serial_number.', USER: '.$actionData['username'].'] ';
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
