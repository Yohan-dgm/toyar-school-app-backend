<?php

namespace Modules\UserManagement\Intents\UserPayment\GetUserPayments;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetUserPaymentsIntent
{
    use AsController;

    public function asController(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $payloadArray = $request->all();
            $actionData = [
                'user_id' => $request->user()?->id,
                'username' => $request->user()?->call_name_with_title ?? 'System',
            ];

            $result = GetUserPaymentsAction::run($payloadArray, $actionData);

            return response()->json([
                "status" => "successful",
                "message" => "User payments retrieved successfully",
                "data" => $result,
                "metadata" => null,
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