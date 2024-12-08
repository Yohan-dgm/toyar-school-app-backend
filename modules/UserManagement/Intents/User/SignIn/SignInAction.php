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

        // Data Prep

        // System Data Prep

        // Final Data Validation

        // // Sign In User (Token Based Authentication)
        // $user = User::where("username", $signInUserDTO["username_or_email"])->first();
        // if ($user) {
        //     if (!Hash::check($signInUserDTO["password"], $user->password)) {
        //         return false;
        //     }
        //     $token = $user->createToken("my-auth-token")->plainTextToken;
        //     return $token;
        // }else{
        //     $user = User::where("email", $signInUserDTO["username_or_email"])->first();
        //     if($user){
        //         if (!Hash::check($signInUserDTO["password"], $user->password)) {
        //             return false;
        //         }
        //         $token = $user->createToken("my-auth-token")->plainTextToken;
        //         return $token;
        //     }else{
        //         return false;
        //     }
        // }

        // Sign In User (Session Based Authentication)
        $credentials_with_username = [
            'username' => $signInUserDTO['username_or_email'],
            'password' => $signInUserDTO['password'],
        ];
        $credentials_with_email = [
            'email' => $signInUserDTO['username_or_email'],
            'password' => $signInUserDTO['password'],
        ];
        if (Auth::attempt($credentials_with_username)) {
            $request->session()->regenerate();
            return $request->user();
        } else if (Auth::attempt($credentials_with_email)) {
            $request->session()->regenerate();
            return $request->user();
        } else {
            return false;
        }
    }
}
