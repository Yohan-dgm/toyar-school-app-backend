<?php

namespace Modules\UserManagement\Intents\User\GetCurrentUserAppUpdateStatus;

use Lorisleiva\Actions\Concerns\AsAction;

class GetCurrentUserAppUpdateStatusAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getCurrentUserAppUpdateStatusUserDTO = GetCurrentUserAppUpdateStatusUserDTO::validate($payloadArray);
        
        // Get the current authenticated user from action data
        $currentUser = $actionData['user'];

        if (!$currentUser) {
            throw new \Exception('User not authenticated');
        }

        return [
            'user_id' => $currentUser->id,
            'username' => $currentUser->username,
            'email' => $currentUser->email,
            'iso_app_version' => $currentUser->iso_app_version,
            'android_app_version' => $currentUser->android_app_version,
            'is_active' => $currentUser->is_active ?? false,
            'user_category' => $currentUser->user_category,
        ];
    }
}