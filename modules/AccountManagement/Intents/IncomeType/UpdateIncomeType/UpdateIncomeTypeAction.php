<?php

namespace Modules\AccountManagement\Intents\IncomeType\UpdateIncomeType;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeType;

class UpdateIncomeTypeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateIncomeTypeUserDTO = UpdateIncomeTypeUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateIncomeTypeSystemDTO = UpdateIncomeTypeSystemDTO::validate($system_data);

        // Final Data Validation
        $updateIncomeTypeDTO = UpdateIncomeTypeDTO::validate(array_merge($updateIncomeTypeUserDTO, $updateIncomeTypeSystemDTO));

        // Save In Database
        IncomeType::where('id', $updateIncomeTypeUserDTO['id'])->update($updateIncomeTypeDTO);
        $incomeType = IncomeType::find($updateIncomeTypeUserDTO['id']);

        return $incomeType;
    }
}
