<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\UpdateExpenseCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseCategory;

class UpdateExpenseCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExpenseCategoryUserDTO = UpdateExpenseCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateExpenseCategorySystemDTO = UpdateExpenseCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $updateExpenseCategoryDTO = UpdateExpenseCategoryDTO::validate(array_merge($updateExpenseCategoryUserDTO, $updateExpenseCategorySystemDTO));

        // Save In Database
        ExpenseCategory::where('id', $updateExpenseCategoryUserDTO['id'])->update($updateExpenseCategoryDTO);
        $expenseCategory = ExpenseCategory::find($updateExpenseCategoryUserDTO['id']);

        return $expenseCategory;
    }
}
