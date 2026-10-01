<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\UpdateTermFeeInvoice;

use Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem\CreateTermFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem\CreateTermFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\TermFeeInvoiceItem;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateTermFeeInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateTermFeeInvoiceUserDTO = UpdateTermFeeInvoiceUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        $updateTermFeeInvoiceSystemDTO = UpdateTermFeeInvoiceSystemDTO::validate($system_data);
        $updateTermFeeInvoiceDTO = UpdateTermFeeInvoiceDTO::validate(array_merge($updateTermFeeInvoiceUserDTO, $updateTermFeeInvoiceSystemDTO));

        TermFeeInvoice::where('id', $updateTermFeeInvoiceUserDTO['id'])->update($updateTermFeeInvoiceDTO);

        $termFeeInvoiceItemList = $updateTermFeeInvoiceUserDTO['term_fee_invoice_item_list'] ?? [];
        // set client side existing item id list
        $clientSideExistingItemIdList = [];
        foreach ($termFeeInvoiceItemList as $item) {
            if (! str_contains(strval($item['id']), '-')) {
                array_push($clientSideExistingItemIdList, $item['id']);
            }
        }
        // set server side existing item id list
        $serverSideExistingItemIdList = TermFeeInvoiceItem::where('term_fee_invoice_id', $updateTermFeeInvoiceUserDTO['id'])->pluck('id')->toArray();

        // set deleted existing item id list
        // elements of the server side array which are not present in the client side array
        $deletedExistingItemIdList = array_diff($serverSideExistingItemIdList, $clientSideExistingItemIdList);

        // delete existing bill items
        // TermFeeInvoice::where("id", $updateTermFeeInvoiceUserDTO['id'])->first()->term_fee_invoice_item_list()->delete();

        // create or update client side bill items
        foreach ($termFeeInvoiceItemList as $item) {
            if (str_contains(strval($item['id']), '-')) {
                // create new client side items
                $item['term_fee_invoice_id'] = $updateTermFeeInvoiceUserDTO['id']; // Assign term_fee_invoice_id
                $updateTermFeeInvoiceItemUserDTO = CreateTermFeeInvoiceItemUserDTO::validate($item);
                $TermFeeInvoiceItemactionData = ['created_by' => $actionData['updated_by']];
                CreateTermFeeInvoiceItemAction::run($updateTermFeeInvoiceItemUserDTO, $TermFeeInvoiceItemactionData);
            } elseif (in_array($item['id'], $serverSideExistingItemIdList)) {
                // update existing server side items
                $data = [];
                $data['term_fee_invoice_id'] = $updateTermFeeInvoiceUserDTO['id'];
                $data['school_fee_id'] = $item['school_fee_id'];
                $data['grade_level_id'] = $item['grade_level_id'];
                $data['term_id'] = $item['term_id'];
                $data['item_total'] = $item['item_total'];
                $data['updated_by'] = $actionData['updated_by'];
                TermFeeInvoiceItem::where('id', $item['id'])->update($data);
            }
        }

        $updatedTermFeeInvoice = TermFeeInvoice::find($updateTermFeeInvoiceUserDTO['id']);

        // create invoice log
        $logData['description'] = '[STATUS: Updated Term Fee Invoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$updatedTermFeeInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Term Fee Invoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $updatedTermFeeInvoice;
    }
}
