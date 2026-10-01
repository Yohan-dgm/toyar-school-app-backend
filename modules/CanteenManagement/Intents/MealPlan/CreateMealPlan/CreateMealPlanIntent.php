<?php

namespace Modules\CanteenManagement\Intents\MealPlan\CreateMealPlan;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateMealPlanIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $payload = array_merge($request->except('image'), [
                'image' => $request->file('image'),
            ]);
            $createMealPlanUserDTO = CreateMealPlanUserDTO::validate($payload);

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;

            $mealPlan = CreateMealPlanAction::run($createMealPlanUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $mealPlan;
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
                201
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
