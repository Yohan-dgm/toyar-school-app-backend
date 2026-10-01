<?php

namespace Modules\UserManagement\Intents\UserPayment\CreateUserPayment;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class CreateUserPaymentIntent
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

            $result = CreateUserPaymentAction::run($payloadArray, $actionData);

            return response()->json([
                "status" => "successful",
                "message" => $result['message'],
                "data" => $result,
                "metadata" => null,
            ], 201);

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
            ], 400);
        }
    }
}