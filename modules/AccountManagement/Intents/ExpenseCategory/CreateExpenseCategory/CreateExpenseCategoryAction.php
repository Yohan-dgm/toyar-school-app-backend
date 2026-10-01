<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\CreateExpenseCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseCategory;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateExpenseCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExpenseCategoryUserDTO = CreateExpenseCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createExpenseCategorySystemDTO = CreateExpenseCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createExpenseCategoryDTO = CreateExpenseCategoryDTO::validate(array_merge($createExpenseCategoryUserDTO, $createExpenseCategorySystemDTO));

        // Save In Database
        $CreateExpenseCategory = ExpenseCategory::create($createExpenseCategoryDTO);

        // create invoice log
        $logData['description'] = '[STATUS: Created Expense Category, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$CreateExpenseCategory->name.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Expense Category';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $CreateExpenseCategory;
    }
}
