<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationDetails;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetNotificationDetailsIntent
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
            $result = GetNotificationDetailsAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => 'Notification details retrieved successfully',
                'data' => $result,
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
                'message' => 'Failed to get notification details: '.$e->getMessage(),
            ], 500);
        }
    }
}
