<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\CreateIncomeCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeCategory;

class CreateIncomeCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createIncomeCategoryUserDTO = CreateIncomeCategoryUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createIncomeCategorySystemDTO = CreateIncomeCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createIncomeCategoryDTO = CreateIncomeCategoryDTO::validate(array_merge($createIncomeCategoryUserDTO, $createIncomeCategorySystemDTO));

        // Save In Database
        $CreateIncomeCategory = IncomeCategory::create($createIncomeCategoryDTO);

        return $CreateIncomeCategory;
    }
}
