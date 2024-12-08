<?php

namespace Modules\UserManagement\Intents\User\SignIn;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class SignInIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization

            // 2. User Data Validation
            $signInUserDTO = SignInUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $signInResult = SignInAction::run($signInUserDTO, $actionData);

            // After Intent

            // Return Response
            if($signInResult){
                $user = $signInResult;
                $data['id'] = $user->id;
                $data['full_name'] = $user->full_name;
                $data['username'] = $user->username;
                $data['email'] = $user->email;
                return $data;
            }else{
                return null;
            }            
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
                        "data" => $result,
                        "metadata" => null,
                    ],
                    200
                );
            } else {
                return response()->json([
                    "status" => "invalid-credentials",
                    "message" => "",
                    "data" => null,
                    "metadata" => null,
                ], 401);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
