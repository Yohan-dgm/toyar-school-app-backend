<?php

namespace Modules\AccountManagement\Intents\MaterialBill\UpdateMaterialBill;

use Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem\CreateMaterialBillItemAction;
use Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem\CreateMaterialBillItemUserDTO;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\MaterialBillItem;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateMaterialBillAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateMaterialBillUserDTO = UpdateMaterialBillUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        $updateMaterialBillSystemDTO = UpdateMaterialBillSystemDTO::validate($system_data);
        $updateMaterialBillDTO = UpdateMaterialBillDTO::validate(array_merge($updateMaterialBillUserDTO, $updateMaterialBillSystemDTO));
        MaterialBill::where('id', $updateMaterialBillUserDTO['id'])->update($updateMaterialBillDTO);

        $materialBillItemList = $updateMaterialBillUserDTO['material_bill_item_list'] ?? [];
        // set client side existing item id list
        $clientSideExistingItemIdList = [];
        foreach ($materialBillItemList as $item) {
            if (! str_contains(strval($item['id']), '-')) {
                array_push($clientSideExistingItemIdList, $item['id']);
            }
        }

        // set server side existing item id list
        $serverSideExistingItemIdList = MaterialBillItem::where('material_bill_id', $updateMaterialBillUserDTO['id'])->pluck('id')->toArray();

        // set deleted existing item id list
        // elements of the server side array which are not present in the client side array
        $deletedExistingItemIdList = array_diff($serverSideExistingItemIdList, $clientSideExistingItemIdList);

        // delete existing bill items
        // MaterialBill::where("id", $updateMaterialBillUserDTO['id'])->first()->material_bill_item_list()->delete();

        $itemResults = [];
        foreach ($materialBillItemList as $item) {
            if (str_contains(strval($item['id']), '-')) {
                // create new client side items
                $item['material_bill_id'] = $updateMaterialBillUserDTO['id']; // Assign material_bill_id
                $updateMaterialBillItemUserDTO = CreateMaterialBillItemUserDTO::validate($item);
                $MaterialBillItemactionData = ['created_by' => $actionData['updated_by']];
                try {
                    $result = CreateMaterialBillItemAction::run($updateMaterialBillItemUserDTO, $MaterialBillItemactionData);
                    $itemResults[] = [
                        'success' => true,
                        'item' => $result,
                    ];
                } catch (\Exception $e) {
                    $itemResults[] = [
                        'success' => false,
                        'error' => $e->getMessage(),
                        'item' => $item,
                    ];
                }
            } elseif (in_array($item['id'], $serverSideExistingItemIdList)) {
                // update existing server side items
                $data = [];
                $data['material_bill_id'] = $updateMaterialBillUserDTO['id'];
                $data['material_item_id'] = $item['material_item_id'];
                $data['item_quantity'] = $item['item_quantity'];
                $data['print_description'] = $item['print_description'];
                $data['print_quantity'] = $item['print_quantity'];
                $data['print_unit'] = $item['print_unit'];
                $data['unit_price'] = $item['unit_price'];
                $data['item_total'] = $item['item_total'];
                $data['updated_by'] = $actionData['updated_by'];
                try {
                    MaterialBillItem::where('id', $item['id'])->update($data);
                    $itemResults[] = [
                        'success' => true,
                        'item' => $item,
                    ];
                } catch (\Exception $e) {
                    $itemResults[] = [
                        'success' => false,
                        'error' => $e->getMessage(),
                        'item' => $item,
                    ];
                }
            }
        }

        $updatedMaterialBill = MaterialBill::find($updateMaterialBillUserDTO['id']);

        if ($updateMaterialBillUserDTO['id'] != null && $updateMaterialBillUserDTO['id'] != 'null') {
            $reciptVoucherSum = ReceiptVoucher::where('material_bill_id', $updateMaterialBillUserDTO['id'])->sum('amount');
            $materialBillSum = MaterialBill::where('id', $updateMaterialBillUserDTO['id'])->select('bill_total')->first();
            if ($reciptVoucherSum >= $materialBillSum->bill_total) {
                MaterialBill::where('id', $updateMaterialBillUserDTO['id'])->update(['is_material_bill_complete' => true]);
            } else {
                MaterialBill::where('id', $updateMaterialBillUserDTO['id'])->update(['is_material_bill_complete' => false]);
            }
        }
        // create invoice log
        $logData['description'] = '[STATUS: Updated Material Bill, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$updatedMaterialBill->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Material Bill';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return [
            'material_bill' => $updatedMaterialBill,
            'item_results' => $itemResults,
        ];
    }
}
