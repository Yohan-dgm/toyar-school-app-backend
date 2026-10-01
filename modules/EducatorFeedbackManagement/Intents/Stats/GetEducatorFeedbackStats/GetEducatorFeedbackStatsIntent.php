<?php

namespace Modules\EducatorFeedbackManagement\Intents\Stats\GetEducatorFeedbackStats;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetEducatorFeedbackStatsIntent
{
    use AsController;

    public function asController(Request $request)
    {
        try {
            // Get request payload
            $payloadArray = $request->all();

            // Get action data (user info from middleware)
            $actionData = [
                'user_id' => $request->user()->id ?? null,
                'username' => $request->user()->username ?? null,
            ];

            // Execute action
            $result = GetEducatorFeedbackStatsAction::run($payloadArray, $actionData);

            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Educator feedback statistics retrieved successfully',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 400);
        }
    }
}
