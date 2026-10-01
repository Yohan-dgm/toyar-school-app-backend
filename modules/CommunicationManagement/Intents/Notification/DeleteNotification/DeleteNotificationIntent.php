<?php

namespace Modules\CommunicationManagement\Intents\Notification\DeleteNotification;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteNotificationIntent
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
            $result = DeleteNotificationAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => $result->message,
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
                'message' => 'Failed to delete notification: '.$e->getMessage(),
            ], 500);
        }
    }
}
