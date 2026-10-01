<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetUserNotifications;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserNotificationsIntent
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
            $result = GetUserNotificationsAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => 'Notifications retrieved successfully',
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
                'message' => 'Failed to retrieve notifications: '.$e->getMessage(),
            ], 500);
        }
    }
}
