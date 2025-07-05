<?php

namespace Modules\UserManagement\Intents\UserProfile\ChangePassword;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateUserUserDTO = ChangePasswordUserDTO::validate($payloadArray);

        // Data Prep   
        $system_data = [];

        $credentials_with_email = [
            'id' => $updateUserUserDTO['id'],
            'password' => $updateUserUserDTO['current_password'],
        ];
        if (Auth::attempt($credentials_with_email)) {
            if ($updateUserUserDTO['new_password'] == $updateUserUserDTO['confirm_password']) {
                // System Data Prep 
                $system_data = [
                    'password' => Hash::make($updateUserUserDTO['new_password']),
                    'password_new' => $updateUserUserDTO['new_password'],
                    'update_by' =>  $actionData['updated_by'],
                ];

                // System Data Validation
                $updateUserSystemDTO = ChangePasswordSystemDTO::validate($system_data);

                // Final Data Validation
                $updateUserDTO = ChangePasswordDTO::validate(array_merge($updateUserUserDTO, $updateUserSystemDTO));
                unset($updateUserDTO['current_password']);
                unset($updateUserDTO['new_password']);
                unset($updateUserDTO['confirm_password']);
                // Save In Database

                User::where('id', $updateUserDTO['id'])->update($updateUserDTO);

                // Auth::guard('web')->logout();
                // return true;
                return User::find($updateUserDTO['id']);
            } else {
                // return ['error_message' => 'New Password and Confirm Password does not match', 'status' => false];
                return false;
            }
        } else {
            // return ['error_message' => 'Current Password does not match', 'status' => false];
            return false;
        }
    }
}
