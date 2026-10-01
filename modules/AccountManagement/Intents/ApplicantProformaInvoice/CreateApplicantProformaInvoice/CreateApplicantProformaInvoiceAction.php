<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoice\CreateApplicantProformaInvoice;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItemAction;
use Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItemUserDTO;
use Modules\AccountManagement\Models\ApplicantProformaInvoice;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateApplicantProformaInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createApplicantProformaInvoiceUserDTO = CreateApplicantProformaInvoiceUserDTO::validate($payloadArray);

        $system_data['serial_number_prefix'] = 'NY/API-BILL';
        $maxDigits = ApplicantProformaInvoice::where(function (Builder $receipt_query) {
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
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['is_applicant_proforma_invoice_complete'] = false;

        $createApplicantProformaInvoiceSystemDTO = CreateApplicantProformaInvoiceSystemDTO::validate($system_data);
        $createApplicantProformaInvoiceDTO = CreateApplicantProformaInvoiceDTO::validate(array_merge($createApplicantProformaInvoiceUserDTO, $createApplicantProformaInvoiceSystemDTO));
        $createdApplicantProformaInvoice = ApplicantProformaInvoice::create($createApplicantProformaInvoiceDTO);

        $applicantProformaInvoiceItemList = $createApplicantProformaInvoiceUserDTO['applicant_proforma_invoice_item_list'] ?? [];
        foreach ($applicantProformaInvoiceItemList as $item) {
            $item['applicant_proforma_invoice_id'] = $createdApplicantProformaInvoice->id; // Assign applicant_proforma_invoice_id
            $createApplicantProformaInvoiceItemUserDTO = CreateApplicantProformaInvoiceItemUserDTO::validate($item);

            $applicantProformaInvoiceItemActionData = ['created_by' => $actionData['created_by']];
            CreateApplicantProformaInvoiceItemAction::run($createApplicantProformaInvoiceItemUserDTO, $applicantProformaInvoiceItemActionData);
        }

        // $createdApplicantProformaInvoice = ApplicantProformaInvoice::find($createdApplicantProformaInvoice->id);

        // create invoice log
        $logData['description'] = '[STATUS: Created Applicant Proforma Iinvoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createdApplicantProformaInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Applicant Proforma Iinvoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createdApplicantProformaInvoice;
    }
}
