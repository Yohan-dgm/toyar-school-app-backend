<?php

namespace Modules\UserManagement\Intents\User\SignOut;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class SignOutIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization

            // 2. User Data Validation

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $signOutResult = SignOutAction::run([], $actionData);

            // After Intent

            // Return Response
            return $signOutResult;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        "status" => "successful",
                        "message" => "",
                        "data" => null,
                        "metadata" => null,
                    ],
                    200
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
