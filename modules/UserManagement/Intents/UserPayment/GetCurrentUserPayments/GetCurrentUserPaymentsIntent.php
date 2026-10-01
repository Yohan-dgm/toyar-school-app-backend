<?php

namespace Modules\UserManagement\Intents\UserPayment\GetCurrentUserPayments;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetCurrentUserPaymentsIntent
{
    use AsController;

    public function asController(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Get request payload (query parameters for GET request)
            $payloadArray = $request->all();
            
            // Action data with current user information
            $actionData = [
                'user_id' => $request->user()?->id,
                'username' => $request->user()?->call_name_with_title ?? 'System',
            ];

            // Ensure user is authenticated
            if (!$actionData['user_id']) {
                return response()->json([
                    "status" => "unauthorized",
                    "message" => "Authentication required",
                    "data" => null,
                    "metadata" => null,
                ], 401);
            }

            // Execute action
            $result = GetCurrentUserPaymentsAction::run($payloadArray, $actionData);

            return response()->json([
                "status" => "successful",
                "message" => "Current user payments retrieved successfully",
                "data" => $result,
                "metadata" => [
                    "user_id" => $actionData['user_id'],
                    "request_timestamp" => now()->toISOString(),
                ],
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "status" => "validation_error",
                "message" => "Validation failed",
                "data" => null,
                "metadata" => [
                    "errors" => $e->errors()
                ],
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
                "data" => null,
                "metadata" => null,
            ], 500);
        }
    }
}