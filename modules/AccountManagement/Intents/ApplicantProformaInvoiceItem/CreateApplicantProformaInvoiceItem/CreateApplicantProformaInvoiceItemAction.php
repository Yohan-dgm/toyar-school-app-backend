<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItem;

use Modules\AccountManagement\Models\ApplicantProformaInvoiceItem;

class CreateApplicantProformaInvoiceItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createApplicantProformaInvoiceItemUserDTO = CreateApplicantProformaInvoiceItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['print_amount'] = $createApplicantProformaInvoiceItemUserDTO['amount'];
        $system_data['print_invoice_type'] = $createApplicantProformaInvoiceItemUserDTO['invoice_type'];
        // quary end

        $createApplicantProformaInvoiceItemSystemDTO = CreateApplicantProformaInvoiceItemSystemDTO::validate($system_data);
        $createApplicantProformaInvoiceItemDTO = CreateApplicantProformaInvoiceItemDTO::validate(array_merge($createApplicantProformaInvoiceItemUserDTO, $createApplicantProformaInvoiceItemSystemDTO));

        $applicantProformaIinvoiceItem = ApplicantProformaInvoiceItem::create($createApplicantProformaInvoiceItemDTO);

        return $applicantProformaIinvoiceItem;
    }
}
