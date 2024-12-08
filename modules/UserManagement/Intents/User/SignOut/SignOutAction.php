<?php

namespace Modules\UserManagement\Intents\User\SignOutUser;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class SignOutUserAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation

        // Data Prep
        
        // System Data Prep
        
        // Final Data Validation

        // Sign Out User
        Auth::guard('web')->logout();

        return true;
    }
}
