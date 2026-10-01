<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\CreateExpenseNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseNote;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateExpenseNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExpenseNoteUserDTO = CreateExpenseNoteUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['serial_number_prefix'] = 'NY/EXP-NOTE';
        $maxDigits = ExpenseNote::where(function (Builder $receipt_query) {
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
        $system_data['is_expense_note_complete'] = false;
        $system_data['is_active'] = true;

        // System Data Validation
        $createExpenseNoteSystemDTO = CreateExpenseNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $createExpenseNoteDTO = CreateExpenseNoteDTO::validate(array_merge($createExpenseNoteUserDTO, $createExpenseNoteSystemDTO));

        // Save In Database
        $createExpenseNote = ExpenseNote::create($createExpenseNoteDTO);

        // create invoice log
        $logData['description'] = '[STATUS: Created Expense Note, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createExpenseNote->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Expense Note';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createExpenseNote;
    }
}
