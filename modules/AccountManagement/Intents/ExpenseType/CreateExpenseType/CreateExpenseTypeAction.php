<?php

namespace Modules\AccountManagement\Intents\ExpenseType\CreateExpenseType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseType;

class CreateExpenseTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExpenseTypeUserDTO = CreateExpenseTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createExpenseTypeSystemDTO = CreateExpenseTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $createExpenseTypeDTO = CreateExpenseTypeDTO::validate(array_merge($createExpenseTypeUserDTO, $createExpenseTypeSystemDTO));

        // Save In Database
        $createExpenseType = ExpenseType::create($createExpenseTypeDTO);

        return $createExpenseType;
    }
}
