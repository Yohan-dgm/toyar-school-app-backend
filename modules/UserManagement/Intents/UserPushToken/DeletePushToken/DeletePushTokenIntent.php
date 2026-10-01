<?php

namespace Modules\UserManagement\Intents\UserPushToken\DeletePushToken;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeletePushTokenIntent extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get authenticated user ID from request
            $userId = $request->user()->id ?? null;

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User authentication required',
                    'errors' => ['auth' => ['User must be authenticated']],
                ], 401);
            }

            $actionData = [
                'user_id' => $userId,
            ];

            $result = DeletePushTokenAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => $result->message,
                'data' => [
                    'deleted_count' => $result->deleted_count,
                ],
            ]);

        } catch (\Spatie\LaravelData\Exceptions\InvalidDataClass $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            \Log::error('DeletePushToken failed', [
                'user_id' => $userId ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete push token',
                'errors' => ['system' => ['An unexpected error occurred']],
            ], 500);
        }
    }
}