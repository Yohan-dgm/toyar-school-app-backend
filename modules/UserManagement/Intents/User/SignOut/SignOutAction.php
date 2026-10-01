<?php

namespace Modules\UserManagement\Intents\User\SignOut;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class SignOutAction
{
    use AsAction;

    public function handle($payloadArray, $actionData, $request)
    {
        // User Data Validation

        // Data Prep

        // System Data Prep

        // Final Data Validation

        // Sign Out User

        // Revoke all tokens...
        // $request->user()->tokens()->delete();

        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        // Revoke a specific token...
        // $request->user()->tokens()->where('id', $tokenId)->delete();

        return true;
    }
}
