<?php

namespace Modules\AccountManagement\Intents\RefundableDeposit\UpdateRefundableDeposit;

use Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem\CreateRefundableDepositItemAction;
use Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem\CreateRefundableDepositItemUserDTO;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\AccountManagement\Models\RefundableDepositItem;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateRefundableDepositAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateRefundableDepositUserDTO = UpdateRefundableDepositUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        $updateRefundableDepositSystemDTO = UpdateRefundableDepositSystemDTO::validate($system_data);
        $updateRefundableDepositDTO = UpdateRefundableDepositDTO::validate(array_merge($updateRefundableDepositUserDTO, $updateRefundableDepositSystemDTO));
        RefundableDeposit::where('id', $updateRefundableDepositUserDTO['id'])->update($updateRefundableDepositDTO);

        $refundableDepositItemList = $updateRefundableDepositUserDTO['refundable_deposit_item_list'] ?? [];
        // set client side existing item id list
        $clientSideExistingItemIdList = [];
        foreach ($refundableDepositItemList as $item) {
            if (! str_contains(strval($item['id']), '-')) {
                array_push($clientSideExistingItemIdList, $item['id']);
            }
        }

        // set server side existing item id list
        $serverSideExistingItemIdList = RefundableDepositItem::where('refundable_deposit_id', $updateRefundableDepositUserDTO['id'])->pluck('id')->toArray();

        // set deleted existing item id list
        // elements of the server side array which are not present in the client side array
        $deletedExistingItemIdList = array_diff($serverSideExistingItemIdList, $clientSideExistingItemIdList);

        // delete existing bill items
        // RefundableDeposit::where("id", $updateRefundableDepositUserDTO['id'])->first()->refundable_deposit_item_list()->delete();

        // create or update client side bill items
        foreach ($refundableDepositItemList as $item) {
            if (str_contains(strval($item['id']), '-')) {
                // create new client side items
                $item['refundable_deposit_id'] = $updateRefundableDepositUserDTO['id']; // Assign refundable_deposit_id
                $updateRefundableDepositItemUserDTO = CreateRefundableDepositItemUserDTO::validate($item);
                $RefundableDepositItemactionData = ['created_by' => $actionData['updated_by']];
                CreateRefundableDepositItemAction::run($updateRefundableDepositItemUserDTO, $RefundableDepositItemactionData);
            } elseif (in_array($item['id'], $serverSideExistingItemIdList)) {
                // update existing server side items
                $data = [];
                $data['refundable_deposit_id'] = $updateRefundableDepositUserDTO['id'];
                $data['material_item_id'] = $item['material_item_id'];
                $data['item_quantity'] = $item['item_quantity'];
                $data['print_description'] = $item['print_description'];
                $data['print_quantity'] = $item['print_quantity'];
                $data['print_unit'] = $item['print_unit'];
                $data['unit_price'] = $item['unit_price'];
                $data['item_total'] = $item['item_total'];
                $data['updated_by'] = $actionData['updated_by'];
                RefundableDepositItem::where('id', $item['id'])->update($data);
            }
        }

        $updatedRefundableDeposit = RefundableDeposit::find($updateRefundableDepositUserDTO['id']);

        // create invoice log
        $logData['description'] = '[STATUS: Updated Refundable Deposit, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$updatedRefundableDeposit->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Refundable Deposit';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $updatedRefundableDeposit;
    }
}
