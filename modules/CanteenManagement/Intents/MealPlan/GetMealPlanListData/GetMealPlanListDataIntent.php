<?php

namespace Modules\CanteenManagement\Intents\MealPlan\GetMealPlanListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMealPlanListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $getMealPlanListDataUserDTO = GetMealPlanListDataUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];

            $mealPlanListData = GetMealPlanListDataAction::run($getMealPlanListDataUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $mealPlanListData;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $result,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
