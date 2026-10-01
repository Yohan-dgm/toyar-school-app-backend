<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\UpdateAdmissionFeeInvoice;

use Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\AdmissionFeeInvoiceItem;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateAdmissionFeeInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateAdmissionFeeInvoiceUserDTO = UpdateAdmissionFeeInvoiceUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['items_total'] = $updateAdmissionFeeInvoiceUserDTO['admission_fee'];

        $updateAdmissionFeeInvoiceSystemDTO = UpdateAdmissionFeeInvoiceSystemDTO::validate($system_data);
        $updateAdmissionFeeInvoiceDTO = UpdateAdmissionFeeInvoiceDTO::validate(array_merge($updateAdmissionFeeInvoiceUserDTO, $updateAdmissionFeeInvoiceSystemDTO));
        AdmissionFeeInvoice::where('id', $updateAdmissionFeeInvoiceUserDTO['id'])->update($updateAdmissionFeeInvoiceDTO);

        $admissionFeeInvoiceItemList = $updateAdmissionFeeInvoiceUserDTO['admission_fee_invoice_item_list'] ?? [];
        // set client side existing item id list
        $clientSideExistingItemIdList = [];
        foreach ($admissionFeeInvoiceItemList as $item) {
            if (! str_contains(strval($item['id']), '-')) {
                array_push($clientSideExistingItemIdList, $item['id']);
            }
        }

        // set server side existing item id list
        $serverSideExistingItemIdList = AdmissionFeeInvoiceItem::where('admission_fee_invoice_id', $updateAdmissionFeeInvoiceUserDTO['id'])->pluck('id')->toArray();

        // set deleted existing item id list
        // elements of the server side array which are not present in the client side array
        $deletedExistingItemIdList = array_diff($serverSideExistingItemIdList, $clientSideExistingItemIdList);

        // delete existing bill items
        // AdmissionFeeInvoice::where("id", $updateAdmissionFeeInvoiceUserDTO['id'])->first()->admission_fee_invoice_item_list()->delete();

        // create or update client side bill items
        foreach ($admissionFeeInvoiceItemList as $item) {
            if (str_contains(strval($item['id']), '-')) {
                // create new client side items
                $item['admission_fee_invoice_id'] = $updateAdmissionFeeInvoiceUserDTO['id']; // Assign admission_fee_invoice_id
                $updateAdmissionFeeInvoiceItemUserDTO = CreateAdmissionFeeInvoiceItemUserDTO::validate($item);
                $AdmissionFeeInvoiceItemactionData = ['created_by' => $actionData['updated_by']];
                CreateAdmissionFeeInvoiceItemAction::run($updateAdmissionFeeInvoiceItemUserDTO, $AdmissionFeeInvoiceItemactionData);
            } elseif (in_array($item['id'], $serverSideExistingItemIdList)) {
                // update existing server side items
                $data = [];
                $data['admission_fee_invoice_id'] = $updateAdmissionFeeInvoiceUserDTO['id'];
                $data['material_item_id'] = $item['material_item_id'];
                $data['item_quantity'] = $item['item_quantity'];
                $data['print_description'] = $item['print_description'];
                $data['print_quantity'] = $item['print_quantity'];
                $data['print_unit'] = $item['print_unit'];
                $data['unit_price'] = $item['unit_price'];
                $data['item_total'] = $item['item_total'];
                $data['updated_by'] = $actionData['updated_by'];
                AdmissionFeeInvoiceItem::where('id', $item['id'])->update($data);
            }
        }

        $updatedAdmissionFeeInvoice = AdmissionFeeInvoice::find($updateAdmissionFeeInvoiceUserDTO['id']);
        // create invoice log
        $logData['description'] = '[STATUS: Updated Admission Fee Invoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$updatedAdmissionFeeInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Admission Fee Invoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $updatedAdmissionFeeInvoice;
    }
}
