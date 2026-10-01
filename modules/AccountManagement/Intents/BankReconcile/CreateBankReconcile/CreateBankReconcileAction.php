<?php

namespace Modules\AccountManagement\Intents\BankReconcile\CreateBankReconcile;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\BankReconcile;
use Modules\AccountManagement\Models\BankStatement;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateBankReconcileAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createBankReconcileUserDTO = CreateBankReconcileUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];
        $system_data['transaction_type'] = BankStatement::find($createBankReconcileUserDTO['bank_statement_id'])->transaction_type;
        $system_data['bank_account_id'] = BankStatement::find($createBankReconcileUserDTO['bank_statement_id'])->bank_account_id;

        $system_data['created_by'] = $actionData['created_by'];
        $system_data['reconciled_by'] = $actionData['created_by'];

        $createBankReconcileSystemDTO = CreateBankReconcileSystemDTO::validate($system_data);

        // Final Data Validation
        $createBankReconcileDTO = CreateBankReconcileDTO::validate(array_merge($createBankReconcileUserDTO, $createBankReconcileSystemDTO));
        $tota_invoice_amount = 0;
        if ($createBankReconcileUserDTO['receipt_voucher_list'] != null) {
            foreach ($createBankReconcileUserDTO['receipt_voucher_list'] as $receipt_voucher) {
                $tota_invoice_amount += ReceiptVoucher::where('id', $receipt_voucher['id'])->get()->first()->amount;
            }
        }
        if ($createBankReconcileUserDTO['payment_voucher_list'] != null) {
            foreach ($createBankReconcileUserDTO['payment_voucher_list'] as $payment_voucher) {
                $tota_invoice_amount += PaymentVoucher::where('id', $payment_voucher['id'])->get()->first()->amount;
            }
        }
        if ($tota_invoice_amount != $createBankReconcileUserDTO['amount']) {
            throw new \Exception('Invoice amount mismatch');
        }
        // Save In Database
        $createBankReconcile = BankReconcile::create($createBankReconcileDTO);
        BankStatement::where('id', $createBankReconcileUserDTO['bank_statement_id'])->update(['is_reconciled' => true]);

        if ($createBankReconcileUserDTO['receipt_voucher_list'] != null) {
            foreach ($createBankReconcileUserDTO['receipt_voucher_list'] as $receipt_voucher) {
                $createBankReconcile->receipt_voucher_list()->attach($receipt_voucher['id']);
                ReceiptVoucher::where('id', $receipt_voucher['id'])->update(['is_reconciled' => true]);
            }
        }
        if ($createBankReconcileUserDTO['payment_voucher_list'] != null) {
            foreach ($createBankReconcileUserDTO['payment_voucher_list'] as $payment_voucher) {
                $createBankReconcile->payment_voucher_list()->attach($payment_voucher['id']);
                PaymentVoucher::where('id', $payment_voucher['id'])->update(['is_reconciled' => true]);
            }
        }

        // create invoice log
        $logData['description'] = '[STATUS: Created Bank Reconcile, IP: '.$_SERVER['REMOTE_ADDR'].', ID: .'.$createBankReconcile->id.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Bank Reconcile';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createBankReconcile;
    }
}
