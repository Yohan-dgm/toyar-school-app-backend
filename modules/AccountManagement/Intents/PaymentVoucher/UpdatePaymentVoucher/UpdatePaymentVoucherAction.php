<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\UpdatePaymentVoucher;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseNote;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\AccountManagement\Models\SupplierBill;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class UpdatePaymentVoucherAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updatePaymentVoucherUserDTO = UpdatePaymentVoucherUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        if ($updatePaymentVoucherUserDTO['payment_method'] == 'Cash') {
            $system_data['payment_issued_date'] = $updatePaymentVoucherUserDTO['cash_paid_date'];
        }
        if ($updatePaymentVoucherUserDTO['payment_method'] == 'Bank Transfer') {
            $system_data['payment_issued_date'] = $updatePaymentVoucherUserDTO['bank_transfer_date'];
        }
        if ($updatePaymentVoucherUserDTO['payment_method'] == 'Check') {
            $system_data['payment_issued_date'] = $updatePaymentVoucherUserDTO['check_issued_date'];
        }

        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updatePaymentVoucherSystemDTO = UpdatePaymentVoucherSystemDTO::validate($system_data);

        // Final Data Validation
        $updatePaymentVoucherDTO = UpdatePaymentVoucherDTO::validate(array_merge($updatePaymentVoucherUserDTO, $updatePaymentVoucherSystemDTO));

        // Save In Database
        PaymentVoucher::where('id', $updatePaymentVoucherUserDTO['id'])->update($updatePaymentVoucherDTO);
        $paymentVoucher = PaymentVoucher::with('purchase_order')->find($updatePaymentVoucherUserDTO['id']);

        if ($updatePaymentVoucherUserDTO['expense_note_id'] != null && $updatePaymentVoucherUserDTO['expense_note_id'] != 'null') {
            $paymentVoucherSum = PaymentVoucher::where('expense_note_id', $updatePaymentVoucherUserDTO['expense_note_id'])->sum('amount');
            $expenseInvoiceSum = ExpenseNote::where('id', $updatePaymentVoucherUserDTO['expense_note_id'])->select('amount')->first();
            if ($paymentVoucherSum >= $expenseInvoiceSum->amount) {
                ExpenseNote::where('id', $updatePaymentVoucherUserDTO['expense_note_id'])->update(['is_expense_note_complete' => true]);
            } else {
                ExpenseNote::where('id', $updatePaymentVoucherUserDTO['expense_note_id'])->update(['is_expense_note_complete' => false]);
            }
        }
        if ($updatePaymentVoucherUserDTO['purchase_order_id'] != null && $updatePaymentVoucherUserDTO['purchase_order_id'] != 'null') {
            $paymentVoucherSum = PaymentVoucher::where('purchase_order_id', $updatePaymentVoucherUserDTO['purchase_order_id'])->sum('amount');
            $purchaseOrderSum = SupplierBill::whereHas('purchase_order')->where('purchase_order_id', $updatePaymentVoucherUserDTO['purchase_order_id'])->sum('bill_total');

            if ($paymentVoucherSum >= floatval($purchaseOrderSum)) {
                PurchaseOrder::where('id', $updatePaymentVoucherUserDTO['purchase_order_id'])->update(['is_purchase_order_complete' => true]);
            } else {
                PurchaseOrder::where('id', $updatePaymentVoucherUserDTO['purchase_order_id'])->update(['is_purchase_order_complete' => false]);
            }
        }

        // create invoice log
        $logData['description'] = '[STATUS: Updated Payment Voucher, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$paymentVoucher->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Payment Voucher';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $paymentVoucher;
    }
}
