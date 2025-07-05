<?php

namespace Modules\UserManagement\Intents\User\SignIn;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class SignInAction
{
    use AsAction;

    public function handle($payloadArray, $actionData, Request $request)
    {
        // User Data Validation
        $signInUserDTO = SignInUserDTO::validate($payloadArray);

        // Sign In User (Token Based Authentication)
        $credentials_with_username = [
            'username' => $signInUserDTO['username_or_email'],
            'password' => $signInUserDTO['password'],
        ];
        $credentials_with_email = [
            'email' => $signInUserDTO['username_or_email'],
            'password' => $signInUserDTO['password'],
        ];
        if (Auth::attempt($credentials_with_username)) {
            $token = $request->user()->createToken('token');
            return $token->plainTextToken;
        } else if (Auth::attempt($credentials_with_email)) {
            $token = $request->user()->createToken('token');
            return $token->plainTextToken;
        } else {
            return false;
        }
    }
}
