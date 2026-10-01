<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationStats;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetNotificationStatsIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get user ID from authenticated user
            $userId = $request->user()->id;

            // Prepare action data
            $actionData = [
                'user_id' => $userId,
            ];

            // Execute action
            $result = GetNotificationStatsAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => 'Notification statistics retrieved successfully',
                'data' => $result,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            \Log::error('GetNotificationStats error: '.$e->getMessage(), [
                'user_id' => $request->user()?->id,
                'request_data' => $request->all(),
                'exception' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve notification statistics',
            ], 500);
        }
    }
}
