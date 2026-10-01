<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoice\UpdateApplicantProformaInvoice;

use Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItemAction;
use Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItemUserDTO;
use Modules\AccountManagement\Models\ApplicantProformaInvoice;
use Modules\AccountManagement\Models\ApplicantProformaInvoiceItem;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateApplicantProformaInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateApplicantProformaInvoiceUserDTO = UpdateApplicantProformaInvoiceUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        $updateApplicantProformaInvoiceSystemDTO = UpdateApplicantProformaInvoiceSystemDTO::validate($system_data);
        $updateApplicantProformaInvoiceDTO = UpdateApplicantProformaInvoiceDTO::validate(array_merge($updateApplicantProformaInvoiceUserDTO, $updateApplicantProformaInvoiceSystemDTO));
        ApplicantProformaInvoice::where('id', $updateApplicantProformaInvoiceUserDTO['id'])->update($updateApplicantProformaInvoiceDTO);

        $applicantProformaInvoiceItemList = $updateApplicantProformaInvoiceUserDTO['applicant_proforma_invoice_item_list'] ?? [];
        // set client side existing item id list
        $clientSideExistingItemIdList = [];
        foreach ($applicantProformaInvoiceItemList as $item) {
            if (! str_contains(strval($item['id']), '-')) {
                array_push($clientSideExistingItemIdList, $item['id']);
            }
        }

        // set server side existing item id list
        $serverSideExistingItemIdList = ApplicantProformaInvoiceItem::where('applicant_proforma_invoice_id', $updateApplicantProformaInvoiceUserDTO['id'])->pluck('id')->toArray();

        // set deleted existing item id list
        // elements of the server side array which are not present in the client side array
        $deletedExistingItemIdList = array_diff($serverSideExistingItemIdList, $clientSideExistingItemIdList);

        // delete existing bill items
        // ApplicantProformaInvoice::where("id", $updateApplicantProformaInvoiceUserDTO['id'])->first()->applicant_proforma_invoice_item_list()->delete();

        // create or update client side bill items
        foreach ($applicantProformaInvoiceItemList as $item) {
            if (str_contains(strval($item['id']), '-')) {
                // create new client side items
                $item['applicant_proforma_invoice_id'] = $updateApplicantProformaInvoiceUserDTO['id']; // Assign applicant_proforma_invoice_id
                $updateApplicantProformaInvoiceItemUserDTO = CreateApplicantProformaInvoiceItemUserDTO::validate($item);
                $ApplicantProformaInvoiceItemactionData = ['created_by' => $actionData['updated_by']];
                CreateApplicantProformaInvoiceItemAction::run($updateApplicantProformaInvoiceItemUserDTO, $ApplicantProformaInvoiceItemactionData);
            } elseif (in_array($item['id'], $serverSideExistingItemIdList)) {
                // update existing server side items
                $data = [];
                $data['applicant_proforma_invoice_id'] = $updateApplicantProformaInvoiceUserDTO['id'];
                $data['material_item_id'] = $item['material_item_id'];
                $data['item_quantity'] = $item['item_quantity'];
                $data['print_description'] = $item['print_description'];
                $data['print_quantity'] = $item['print_quantity'];
                $data['print_unit'] = $item['print_unit'];
                $data['unit_price'] = $item['unit_price'];
                $data['item_total'] = $item['item_total'];
                $data['updated_by'] = $actionData['updated_by'];
                ApplicantProformaInvoiceItem::where('id', $item['id'])->update($data);
            }
        }

        $updatedApplicantProformaInvoice = ApplicantProformaInvoice::find($updateApplicantProformaInvoiceUserDTO['id']);

        if ($updateApplicantProformaInvoiceUserDTO['id'] != null && $updateApplicantProformaInvoiceUserDTO['id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('applicant_proforma_invoice_id', $updateApplicantProformaInvoiceUserDTO['id'])->sum('amount');
            $applicantProformaInvoiceSum = ApplicantProformaInvoice::where('id', $updateApplicantProformaInvoiceUserDTO['id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $applicantProformaInvoiceSum->bill_total) {
                ApplicantProformaInvoice::where('id', $updateApplicantProformaInvoiceUserDTO['id'])->update(['is_applicant_proforma_invoice_complete' => true]);
            } else {
                ApplicantProformaInvoice::where('id', $updateApplicantProformaInvoiceUserDTO['id'])->update(['is_applicant_proforma_invoice_complete' => false]);
            }
        }
        // create invoice log
        $logData['description'] = '[STATUS: Updated Applicant Proforma Iinvoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$updatedApplicantProformaInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Applicant Proforma Iinvoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $updatedApplicantProformaInvoice;
    }
}
