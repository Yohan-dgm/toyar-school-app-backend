<?php

namespace Modules\CommunicationManagement\Intents\Notification\CreateNotification;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateNotificationIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get user ID from authenticated user
            $userId = $request->user()->id;

            // Prepare action data
            $actionData = [
                'created_by' => $userId,
            ];

            // Execute action
            $result = CreateNotificationAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => 'Notification created successfully',
                'data' => $result,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create notification: '.$e->getMessage(),
            ], 500);
        }
    }
}
