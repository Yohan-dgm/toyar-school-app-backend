<?php

namespace Modules\AccountManagement\Intents\RefundableDeposit\CreateRefundableDeposit;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem\CreateRefundableDepositItemAction;
use Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem\CreateRefundableDepositItemUserDTO;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\AccountManagement\Models\SchoolFee;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateRefundableDepositAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createRefundableDepositUserDTO = CreateRefundableDepositUserDTO::validate($payloadArray);

        $system_data['serial_number_prefix'] = 'NY/REF-INV';
        $maxDigits = RefundableDeposit::where(function (Builder $receipt_query) {
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
        $schoolFee = SchoolFee::where('school_fee_type', 'Refundable Deposit')
            ->where('is_active', true)->first();
        $system_data['items_total'] = $schoolFee->amount;
        // $system_data['service_charges_total'] = 0;
        $system_data['subtotal_before_discount'] = $schoolFee->amount;
        $system_data['subtotal_after_discount'] = $system_data['subtotal_before_discount'] - $createRefundableDepositUserDTO['discount_total'];
        $system_data['bill_total'] = $createRefundableDepositUserDTO['amount'];
        $system_data['is_refundable_deposit_complete'] = false;
        $system_data['is_refund'] = false;

        $createRefundableDepositSystemDTO = CreateRefundableDepositSystemDTO::validate($system_data);
        $createRefundableDepositDTO = CreateRefundableDepositDTO::validate(array_merge($createRefundableDepositUserDTO, $createRefundableDepositSystemDTO));
        $createdRefundableDeposit = RefundableDeposit::create($createRefundableDepositDTO);

        $refundableDepositData = [];
        $refundableDepositData['refundable_deposit_id'] = $createdRefundableDeposit->id;
        $refundableDepositData['school_fee_id'] = $schoolFee->id;
        $refundableDepositData['description'] = $schoolFee->name;
        $refundableDepositData['is_refundable_deposit_item_complete'] = false;
        $refundableDepositData['item_total'] = $schoolFee->amount;

        $createRefundableDepositItemUserDTO = CreateRefundableDepositItemUserDTO::validate($refundableDepositData);
        $refundableDepositItemActionData = ['created_by' => $actionData['created_by']];
        CreateRefundableDepositItemAction::run($createRefundableDepositItemUserDTO, $refundableDepositItemActionData);

        // $createdRefundableDeposit = RefundableDeposit::get();

        // create invoice log
        $logData['description'] = '[STATUS: Created Refundable Deposit, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createdRefundableDeposit->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Refundable Deposit';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createdRefundableDeposit;
    }
}
