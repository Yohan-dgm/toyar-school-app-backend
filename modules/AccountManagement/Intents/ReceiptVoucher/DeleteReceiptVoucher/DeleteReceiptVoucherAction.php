<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\DeleteReceiptVoucher;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\TermFeePayment;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class DeleteReceiptVoucherAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteReceiptVoucherUserDTO = DeleteReceiptVoucherUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['deleted_by'] = $actionData['updated_by'];
        $system_data['deleted_date'] = date('Y-m-d'.' '.'H:i:s');
        $system_data['is_active'] = false;

        // System Data Validation
        $deleteReceiptVoucherSystemDTO = DeleteReceiptVoucherSystemDTO::validate($system_data);
        // Final Data Validation

        $deleteReceiptVoucherDTO = DeleteReceiptVoucherDTO::validate(array_merge($deleteReceiptVoucherUserDTO, $deleteReceiptVoucherSystemDTO));

        // Save In Database
        $recipt_id = $deleteReceiptVoucherDTO['id'];
        unset($deleteReceiptVoucherDTO['id']);
        ReceiptVoucher::where('id', $recipt_id)->update($deleteReceiptVoucherDTO);

        $termFeePayment = TermFeePayment::where('receipt_voucher_id', $recipt_id)->get();
        if (count($termFeePayment) > 0) {
            foreach ($termFeePayment as $key => $value) {
                $sum_paid_amount = TermFeePayment::where('id', $value->id)->sum('paid_amount');
                $termFeePayment = TermFeeInvoice::where('id', $value->term_fee_invoice_id)->get()->first();

                if ($sum_paid_amount <= $termFeePayment->bill_total) {
                    TermFeeInvoice::where('id', $termFeePayment->id)->update(['is_term_fee_invoice_complete' => false]);
                }
                TermFeePayment::where('id', $value->id)->delete();
            }
        }

        $deleteReceiptVoucher = ReceiptVoucher::where('id', $recipt_id)->first();

        // create invoice log
        $logData['description'] = '[STATUS: Deleted Receipt Voucher, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$deleteReceiptVoucher->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Receipt Voucher';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $deleteReceiptVoucher;
    }
}
