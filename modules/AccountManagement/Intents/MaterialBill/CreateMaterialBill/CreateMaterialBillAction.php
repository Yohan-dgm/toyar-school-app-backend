<?php

namespace Modules\AccountManagement\Intents\MaterialBill\CreateMaterialBill;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem\CreateMaterialBillItemAction;
use Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem\CreateMaterialBillItemUserDTO;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateMaterialBillAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createMaterialBillUserDTO = CreateMaterialBillUserDTO::validate($payloadArray);

        $system_data['serial_number_prefix'] = 'NY/MAT-BILL';
        $maxDigits = MaterialBill::where(function (Builder $receipt_query) {
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
        $system_data['is_material_bill_complete'] = false;

        $createMaterialBillSystemDTO = CreateMaterialBillSystemDTO::validate($system_data);
        $createMaterialBillDTO = CreateMaterialBillDTO::validate(array_merge($createMaterialBillUserDTO, $createMaterialBillSystemDTO));
        $createdMaterialBill = MaterialBill::create($createMaterialBillDTO);

        $materialBillItemList = $createMaterialBillUserDTO['material_bill_item_list'] ?? [];
        $itemResults = [];
        foreach ($materialBillItemList as $item) {
            $item['material_bill_id'] = $createdMaterialBill->id; // Assign material_bill_id
            $createMaterialBillItemUserDTO = CreateMaterialBillItemUserDTO::validate($item);
            $materialBillItemActionData = ['created_by' => $actionData['created_by']];
            try {
                $result = CreateMaterialBillItemAction::run($createMaterialBillItemUserDTO, $materialBillItemActionData);
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
        }

        $createdMaterialBill = MaterialBill::find($createdMaterialBill->id);

        // create invoice log
        $logData['description'] = '[STATUS: Created Material Bill, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createdMaterialBill->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Material Bill';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return [
            'material_bill' => $createdMaterialBill,
            'item_results' => $itemResults,
        ];
    }
}
