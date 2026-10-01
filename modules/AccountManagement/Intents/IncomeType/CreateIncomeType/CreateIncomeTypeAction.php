<?php

namespace Modules\AccountManagement\Intents\IncomeType\CreateIncomeType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeType;

class CreateIncomeTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createIncomeTypeUserDTO = CreateIncomeTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createIncomeTypeSystemDTO = CreateIncomeTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $createIncomeTypeDTO = CreateIncomeTypeDTO::validate(array_merge($createIncomeTypeUserDTO, $createIncomeTypeSystemDTO));

        // Save In Database
        $createIncomeType = IncomeType::create($createIncomeTypeDTO);

        return $createIncomeType;
    }
}
