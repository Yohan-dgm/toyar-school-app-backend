<?php

namespace Modules\UserManagement\Intents\UserPushToken\DeletePushToken;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\UserPushToken;

class DeletePushTokenAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deletePushTokenUserDTO = DeletePushTokenUserDTO::validate($payloadArray);

        // System Data Prep
        $systemData = [
            'user_id' => $actionData['user_id'],
        ];

        // System Data Validation
        $deletePushTokenSystemDTO = DeletePushTokenSystemDTO::validate($systemData);

        // Final Data Validation
        $deletePushTokenDTO = DeletePushTokenDTO::validate(
            array_merge($deletePushTokenUserDTO, $deletePushTokenSystemDTO)
        );

        // Build query
        $query = UserPushToken::where('user_id', $deletePushTokenDTO['user_id']);

        if ($deletePushTokenDTO['device_id']) {
            $query->where('device_id', $deletePushTokenDTO['device_id']);
        }

        if ($deletePushTokenDTO['push_token']) {
            $query->where('push_token', $deletePushTokenDTO['push_token']);
        }

        // If neither device_id nor push_token is provided, delete all tokens for the user
        $deletedCount = $query->delete();

        $message = match (true) {
            $deletePushTokenDTO['device_id'] && $deletePushTokenDTO['push_token'] => 
                'Push token for specific device and token deleted',
            $deletePushTokenDTO['device_id'] => 
                'Push tokens for device deleted',
            $deletePushTokenDTO['push_token'] => 
                'Specific push token deleted',
            default => 'All push tokens deleted'
        };

        // Prepare response data
        $responseData = [
            'deleted_count' => $deletedCount,
            'message' => $message,
        ];

        return DeletePushTokenResDTO::from($responseData);
    }
}