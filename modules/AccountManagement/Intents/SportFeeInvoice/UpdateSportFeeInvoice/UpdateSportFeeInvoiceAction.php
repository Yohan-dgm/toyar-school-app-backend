<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoice\UpdateSportFeeInvoice;

use Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem\CreateSportFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem\CreateSportFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\SportFeeInvoiceItem;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateSportFeeInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateSportFeeInvoiceUserDTO = UpdateSportFeeInvoiceUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        $updateSportFeeInvoiceSystemDTO = UpdateSportFeeInvoiceSystemDTO::validate($system_data);
        $updateSportFeeInvoiceDTO = UpdateSportFeeInvoiceDTO::validate(array_merge($updateSportFeeInvoiceUserDTO, $updateSportFeeInvoiceSystemDTO));
        SportFeeInvoice::where('id', $updateSportFeeInvoiceUserDTO['id'])->update($updateSportFeeInvoiceDTO);

        $sportFeeInvoiceItemList = $updateSportFeeInvoiceUserDTO['sport_fee_invoice_item_list'] ?? [];
        // set client side existing item id list
        $clientSideExistingItemIdList = [];
        foreach ($sportFeeInvoiceItemList as $item) {
            if (! str_contains(strval($item['id']), '-')) {
                array_push($clientSideExistingItemIdList, $item['id']);
            }
        }

        // set server side existing item id list
        $serverSideExistingItemIdList = SportFeeInvoiceItem::where('sport_fee_invoice_id', $updateSportFeeInvoiceUserDTO['id'])->pluck('id')->toArray();

        // set deleted existing item id list
        // elements of the server side array which are not present in the client side array
        $deletedExistingItemIdList = array_diff($serverSideExistingItemIdList, $clientSideExistingItemIdList);

        // delete existing bill items
        // SportFeeInvoice::where("id", $updateSportFeeInvoiceUserDTO['id'])->first()->sport_fee_invoice_item_list()->delete();

        // create or update client side bill items
        foreach ($sportFeeInvoiceItemList as $item) {
            if (str_contains(strval($item['id']), '-')) {
                // create new client side items
                $item['sport_fee_invoice_id'] = $updateSportFeeInvoiceUserDTO['id']; // Assign sport_fee_invoice_id
                $updateSportFeeInvoiceItemUserDTO = CreateSportFeeInvoiceItemUserDTO::validate($item);
                $SportFeeInvoiceItemactionData = ['created_by' => $actionData['updated_by']];
                CreateSportFeeInvoiceItemAction::run($updateSportFeeInvoiceItemUserDTO, $SportFeeInvoiceItemactionData);
            } elseif (in_array($item['id'], $serverSideExistingItemIdList)) {
                // update existing server side items
                $data = [];
                $data['sport_fee_invoice_id'] = $updateSportFeeInvoiceUserDTO['id'];
                $data['material_item_id'] = $item['material_item_id'];
                $data['item_quantity'] = $item['item_quantity'];
                $data['print_description'] = $item['print_description'];
                $data['print_quantity'] = $item['print_quantity'];
                $data['print_unit'] = $item['print_unit'];
                $data['unit_price'] = $item['unit_price'];
                $data['item_total'] = $item['item_total'];
                $data['updated_by'] = $actionData['updated_by'];
                SportFeeInvoiceItem::where('id', $item['id'])->update($data);
            }
        }

        $updatedSportFeeInvoice = SportFeeInvoice::find($updateSportFeeInvoiceUserDTO['id']);

        // create invoice log
        $logData['description'] = '[STATUS: Updated Sport Fee Invoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$updatedSportFeeInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Sport Fee Invoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $updatedSportFeeInvoice;
    }
}
