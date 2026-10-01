<?php

namespace Modules\CanteenManagement\Intents\MealPlan\DeleteMealPlan;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;

class DeleteMealPlanAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteMealPlanUserDTO = DeleteMealPlanUserDTO::validate($payloadArray);

        $mealPlan = CanteenMealPlan::find($deleteMealPlanUserDTO['id']);
        if (! $mealPlan) {
            throw new \Exception('Meal plan not found');
        }

        // System Data Validation
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $deleteMealPlanSystemDTO = DeleteMealPlanSystemDTO::validate($system_data);

        // Soft delete - preserves order history that references this meal plan
        CanteenMealPlan::where('id', $deleteMealPlanUserDTO['id'])->update([
            'is_active' => false,
            'updated_by' => $deleteMealPlanSystemDTO['updated_by'],
        ]);

        return CanteenMealPlan::find($deleteMealPlanUserDTO['id']);
    }
}
