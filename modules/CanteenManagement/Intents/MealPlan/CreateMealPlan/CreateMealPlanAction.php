<?php

namespace Modules\CanteenManagement\Intents\MealPlan\CreateMealPlan;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;
use Modules\CanteenManagement\Support\MealPlanImageStorage;

class CreateMealPlanAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createMealPlanUserDTO = CreateMealPlanUserDTO::validate($payloadArray);

        $imagePath = MealPlanImageStorage::store($createMealPlanUserDTO['image']);

        // System Data Prep
        $system_data = [];
        $system_data['image_path'] = $imagePath;
        $system_data['is_active'] = true;
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createMealPlanSystemDTO = CreateMealPlanSystemDTO::validate($system_data);

        // Final Data Validation
        $finalData = array_merge(
            [
                'title' => $createMealPlanUserDTO['title'],
                'description' => $createMealPlanUserDTO['description'],
                'price' => $createMealPlanUserDTO['price'],
                'quantity_available' => $createMealPlanUserDTO['quantity_available'],
            ],
            $createMealPlanSystemDTO
        );
        $createMealPlanDTO = CreateMealPlanDTO::validate($finalData);

        return CanteenMealPlan::create($createMealPlanDTO);
    }
}
