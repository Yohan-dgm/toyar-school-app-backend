<?php

namespace Modules\CanteenManagement\Intents\MealPlan\UpdateMealPlan;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;
use Modules\CanteenManagement\Support\MealPlanImageStorage;

class UpdateMealPlanAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateMealPlanUserDTO = UpdateMealPlanUserDTO::validate($payloadArray);

        $mealPlan = CanteenMealPlan::find($updateMealPlanUserDTO['id']);
        if (! $mealPlan) {
            throw new \Exception('Meal plan not found');
        }

        $imagePath = $mealPlan->image_path;
        if ($updateMealPlanUserDTO['image']) {
            $imagePath = MealPlanImageStorage::store($updateMealPlanUserDTO['image']);
            MealPlanImageStorage::delete($mealPlan->image_path);
        }

        // System Data Prep
        $system_data = [];
        $system_data['image_path'] = $imagePath;
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateMealPlanSystemDTO = UpdateMealPlanSystemDTO::validate($system_data);

        // Final Data Validation
        $finalData = array_merge(
            [
                'title' => $updateMealPlanUserDTO['title'],
                'description' => $updateMealPlanUserDTO['description'],
                'price' => $updateMealPlanUserDTO['price'],
                'quantity_available' => $updateMealPlanUserDTO['quantity_available'],
                'is_active' => $updateMealPlanUserDTO['is_active'] ?? $mealPlan->is_active,
            ],
            $updateMealPlanSystemDTO
        );
        $updateMealPlanDTO = UpdateMealPlanDTO::validate($finalData);

        CanteenMealPlan::where('id', $updateMealPlanUserDTO['id'])->update($updateMealPlanDTO);

        return CanteenMealPlan::find($updateMealPlanUserDTO['id']);
    }
}
