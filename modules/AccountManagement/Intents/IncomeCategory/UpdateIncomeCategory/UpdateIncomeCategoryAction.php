<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\UpdateIncomeCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeCategory;

class UpdateIncomeCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateIncomeCategoryUserDTO = UpdateIncomeCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateIncomeCategorySystemDTO = UpdateIncomeCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $updateIncomeCategoryDTO = UpdateIncomeCategoryDTO::validate(array_merge($updateIncomeCategoryUserDTO, $updateIncomeCategorySystemDTO));

        // Save In Database
        IncomeCategory::where('id', $updateIncomeCategoryUserDTO['id'])->update($updateIncomeCategoryDTO);
        $incomeCategory = IncomeCategory::find($updateIncomeCategoryUserDTO['id']);

        return $incomeCategory;
    }
}
