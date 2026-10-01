<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\CreatePaymentVoucher;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseNote;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\AccountManagement\Models\SupplierBill;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class CreatePaymentVoucherAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createPaymentVoucherUserDTO = CreatePaymentVoucherUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['serial_number_prefix'] = 'NY/PV';
        $maxDigits = PaymentVoucher::where(function (Builder $receipt_query) {
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

        if ($createPaymentVoucherUserDTO['payment_method'] == 'Cash') {
            $system_data['payment_issued_date'] = $createPaymentVoucherUserDTO['cash_paid_date'];
        }
        if ($createPaymentVoucherUserDTO['payment_method'] == 'Bank Transfer') {
            $system_data['payment_issued_date'] = $createPaymentVoucherUserDTO['bank_transfer_date'];
        }
        if ($createPaymentVoucherUserDTO['payment_method'] == 'Check') {
            $system_data['payment_issued_date'] = $createPaymentVoucherUserDTO['check_issued_date'];
        }

        $system_data['created_by'] = $actionData['created_by'];
        $system_data['is_active'] = true;

        // System Data Validation
        $createPaymentVoucherSystemDTO = CreatePaymentVoucherSystemDTO::validate($system_data);

        // Final Data Validation
        $createPaymentVoucherDTO = CreatePaymentVoucherDTO::validate(array_merge($createPaymentVoucherUserDTO, $createPaymentVoucherSystemDTO));

        // Save In Database
        $createPaymentVoucher = PaymentVoucher::create($createPaymentVoucherDTO);
        $createdPaymentVoucher = PaymentVoucher::with('purchase_order')->find($createPaymentVoucher->id);

        if ($createPaymentVoucherUserDTO['expense_note_id'] != null && $createPaymentVoucherUserDTO['expense_note_id'] != 'null') {
            $paymentVoucherSum = PaymentVoucher::where('expense_note_id', $createPaymentVoucherUserDTO['expense_note_id'])->sum('amount');
            $expenseInvoiceSum = ExpenseNote::where('id', $createPaymentVoucherUserDTO['expense_note_id'])->select('amount')->first();
            if ($paymentVoucherSum >= $expenseInvoiceSum->amount) {
                ExpenseNote::where('id', $createPaymentVoucherUserDTO['expense_note_id'])->update(['is_expense_note_complete' => true]);
            } else {
                ExpenseNote::where('id', $createPaymentVoucherUserDTO['expense_note_id'])->update(['is_expense_note_complete' => false]);
            }
        }
        if ($createPaymentVoucherUserDTO['purchase_order_id'] != null && $createPaymentVoucherUserDTO['purchase_order_id'] != 'null') {
            $paymentVoucherSum = PaymentVoucher::where('purchase_order_id', $createPaymentVoucherUserDTO['purchase_order_id'])->sum('amount');
            $purchaseOrderSum = SupplierBill::whereHas('purchase_order')->where('purchase_order_id', $createPaymentVoucherUserDTO['purchase_order_id'])->sum('bill_total');

            if ($paymentVoucherSum >= floatval($purchaseOrderSum)) {
                PurchaseOrder::where('id', $createPaymentVoucherUserDTO['purchase_order_id'])->update(['is_purchase_order_complete' => true]);
            } else {
                PurchaseOrder::where('id', $createPaymentVoucherUserDTO['purchase_order_id'])->update(['is_purchase_order_complete' => false]);
            }
        }

        // create invoice log
        $logData['description'] = '[STATUS: Created Payment Voucher, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createPaymentVoucher->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Payment Voucher';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createdPaymentVoucher;
    }
}
