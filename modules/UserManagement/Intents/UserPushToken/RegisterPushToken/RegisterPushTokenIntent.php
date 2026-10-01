<?php

namespace Modules\UserManagement\Intents\UserPushToken\RegisterPushToken;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterPushTokenIntent extends Controller
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

            $result = RegisterPushTokenAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => $result->was_updated ? 'Push token updated successfully' : 'Push token registered successfully',
                'data' => $result,
            ]);

        } catch (\Spatie\LaravelData\Exceptions\InvalidDataClass $e) {
            \Log::error('RegisterPushToken validation failed', [
                'user_id' => $userId ?? null,
                'request_data' => $request->all(),
                'validation_errors' => $e->errors(),
                'error_message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('RegisterPushToken database error', [
                'user_id' => $userId ?? null,
                'request_data' => $request->all(),
                'sql_error_code' => $e->getCode(),
                'sql_error_message' => $e->getMessage(),
                'sql_bindings' => $e->getBindings(),
            ]);

            // Handle specific database errors
            if ($e->getCode() === '23505') { // Unique violation
                return response()->json([
                    'success' => false,
                    'message' => 'Push token already exists for another device',
                    'errors' => ['push_token' => ['This push token is already registered']],
                ], 409);
            }

            return response()->json([
                'success' => false,
                'message' => 'Database error occurred',
                'errors' => ['database' => ['Unable to save push token']],
            ], 500);

        } catch (\Exception $e) {
            \Log::error('RegisterPushToken general error', [
                'user_id' => $userId ?? null,
                'request_data' => $request->all(),
                'error_class' => get_class($e),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to register push token: ' . $e->getMessage(),
                'errors' => ['system' => ['An unexpected error occurred: ' . $e->getMessage()]],
            ], 500);
        }
    }
}