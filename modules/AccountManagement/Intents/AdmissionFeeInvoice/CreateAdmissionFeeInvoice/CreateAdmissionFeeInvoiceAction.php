<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\CreateAdmissionFeeInvoice;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\SchoolFee;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateAdmissionFeeInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createAdmissionFeeInvoiceUserDTO = CreateAdmissionFeeInvoiceUserDTO::validate($payloadArray);

        //serial No. start
        $system_data['serial_number_prefix'] = 'NY/ADM-INV';
        $maxDigits = AdmissionFeeInvoice::where(function (Builder $receipt_query) {
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
        //serial No. end
        $schoolFee = SchoolFee::where('school_fee_type', 'Admission Fee')->where('is_active', true)->first();
        // $system_data['discount_total'] = $schoolFee->amount - $createAdmissionFeeInvoiceUserDTO['amount'];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['items_total'] = $schoolFee->amount;
        // $system_data['service_charges_total'] = 0;
        $system_data['subtotal_before_discount'] = $schoolFee->amount;
        $system_data['subtotal_after_discount'] = $system_data['subtotal_before_discount'] - $createAdmissionFeeInvoiceUserDTO['discount_total'];
        $system_data['bill_total'] = $createAdmissionFeeInvoiceUserDTO['amount'];
        $system_data['is_admission_fee_invoice_complete'] = false;

        $createAdmissionFeeInvoiceSystemDTO = CreateAdmissionFeeInvoiceSystemDTO::validate($system_data);
        $createAdmissionFeeInvoiceDTO = CreateAdmissionFeeInvoiceDTO::validate(array_merge($createAdmissionFeeInvoiceUserDTO, $createAdmissionFeeInvoiceSystemDTO));
        $createdAdmissionFeeInvoice = AdmissionFeeInvoice::create($createAdmissionFeeInvoiceDTO);

        //create admission fee invoice item
        $admissionFeeInvoiceData = [];
        $admissionFeeInvoiceData['admission_fee_invoice_id'] = $createdAdmissionFeeInvoice->id;
        $admissionFeeInvoiceData['school_fee_id'] = $schoolFee->id;
        $admissionFeeInvoiceData['description'] = $schoolFee->name;
        $admissionFeeInvoiceData['is_admission_fee_invoice_item_complete'] = false;
        $admissionFeeInvoiceData['item_total'] = $schoolFee->amount;

        $createAdmissionFeeInvoiceItemUserDTO = CreateAdmissionFeeInvoiceItemUserDTO::validate($admissionFeeInvoiceData);
        $admissionFeeInvoiceItemActionData = ['created_by' => $actionData['created_by']];
        CreateAdmissionFeeInvoiceItemAction::run($createAdmissionFeeInvoiceItemUserDTO, $admissionFeeInvoiceItemActionData);

        // $createdAdmissionFeeInvoice = AdmissionFeeInvoice::get();

        // create invoice log
        $logData['description'] = '[STATUS: Created Admission Fee Invoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createdAdmissionFeeInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Admission Fee Invoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createdAdmissionFeeInvoice;
    }
}
