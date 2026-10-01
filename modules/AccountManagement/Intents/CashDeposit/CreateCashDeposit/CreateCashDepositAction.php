<?php

namespace Modules\AccountManagement\Intents\CashDeposit\CreateCashDeposit;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\CashDepositItem\CreateCashDepositItem\CreateCashDepositItemAction;
use Modules\AccountManagement\Intents\CashDepositItem\CreateCashDepositItem\CreateCashDepositItemUserDTO;
use Modules\AccountManagement\Models\CashDeposit;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateCashDepositAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createCashDepositUserDTO = CreateCashDepositUserDTO::validate($payloadArray);

        $system_data['serial_number_prefix'] = 'NY/ADM-INV';
        $maxDigits = CashDeposit::where(function (Builder $receipt_query) {
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
        $system_data['is_attached'] = false;

        $createCashDepositSystemDTO = CreateCashDepositSystemDTO::validate($system_data);
        $createCashDepositDTO = CreateCashDepositDTO::validate(array_merge($createCashDepositUserDTO, $createCashDepositSystemDTO));

        $createCashDeposit = CashDeposit::create($createCashDepositDTO);

        $receipt_voucher_list = $createCashDepositUserDTO['receipt_voucher_list'] ?? [];
        foreach ($receipt_voucher_list as $item) {
            $item['cash_deposit_id'] = $createCashDeposit->id; // Assign cash_deposit_id
            $item['receipt_voucher_id'] = $item['id'];

            $itemDTO = CreateCashDepositItemUserDTO::validate($item);

            $CashDepositItemactionData = ['created_by' => $actionData['created_by']];
            CreateCashDepositItemAction::run($itemDTO, $CashDepositItemactionData);
        }

        // create invoice log
        $logData['description'] = '[STATUS: Created Cash Deposit, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createCashDeposit->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Cash Deposit';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createCashDeposit;
    }
}
