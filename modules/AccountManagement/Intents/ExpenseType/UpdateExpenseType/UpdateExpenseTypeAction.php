<?php

namespace Modules\AccountManagement\Intents\ExpenseType\UpdateExpenseType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseType;

class UpdateExpenseTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExpenseTypeUserDTO = UpdateExpenseTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateExpenseTypeSystemDTO = UpdateExpenseTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $updateExpenseTypeDTO = UpdateExpenseTypeDTO::validate(array_merge($updateExpenseTypeUserDTO, $updateExpenseTypeSystemDTO));

        // Save In Database
        ExpenseType::where('id', $updateExpenseTypeUserDTO['id'])->update($updateExpenseTypeDTO);
        $expenseType = ExpenseType::find($updateExpenseTypeUserDTO['id']);

        return $expenseType;
    }
}
