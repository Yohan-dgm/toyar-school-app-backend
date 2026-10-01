<?php

namespace Modules\CanteenManagement\Intents\MealPlan\GetActiveMealPlanListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;

class GetActiveMealPlanListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $mealPlans = CanteenMealPlan::where('is_active', true)
                ->orderBy('title')
                ->get();

            DB::commit();
            // After Intent

            // Return Response
            return $mealPlans;
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
