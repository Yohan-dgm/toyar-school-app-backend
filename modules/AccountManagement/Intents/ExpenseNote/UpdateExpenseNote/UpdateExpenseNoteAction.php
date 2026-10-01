<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\UpdateExpenseNote;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseNote;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateExpenseNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExpenseNoteUserDTO = UpdateExpenseNoteUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateExpenseNoteSystemDTO = UpdateExpenseNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $updateExpenseNoteDTO = UpdateExpenseNoteDTO::validate(array_merge($updateExpenseNoteUserDTO, $updateExpenseNoteSystemDTO));

        // Save In Database
        ExpenseNote::where('id', $updateExpenseNoteUserDTO['id'])->update($updateExpenseNoteDTO);
        $expenseNote = ExpenseNote::where('id', $updateExpenseNoteUserDTO['id'])->first();

        if ($updateExpenseNoteUserDTO['id'] != null && $updateExpenseNoteUserDTO['id'] != 'null') {
            $paymentVoucherSum = PaymentVoucher::where('expense_note_id', $updateExpenseNoteUserDTO['id'])->sum('amount');
            $expenseInvoiceSum = ExpenseNote::where('id', $updateExpenseNoteUserDTO['id'])->select('amount')->first();
            if ($paymentVoucherSum >= $expenseInvoiceSum->amount) {
                ExpenseNote::where('id', $updateExpenseNoteUserDTO['id'])->update(['is_expense_note_complete' => true]);
            } else {
                ExpenseNote::where('id', $updateExpenseNoteUserDTO['id'])->update(['is_expense_note_complete' => false]);
            }
        }

        // create invoice log
        $logData['description'] = '[STATUS: Updated Expense Note, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$expenseNote->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Expense Note';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $expenseNote;
    }
}
