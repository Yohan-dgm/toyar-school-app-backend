<?php

namespace Modules\UserManagement\Intents\User\UpdateUser;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\UserManagement\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateUserUserDTO = UpdateUserUserDTO::validate($payloadArray);

        // Data Prep   
        $system_data = [];

        // System Data Prep 
        $system_data['updated_by'] = $actionData['updated_by'];

        $studentSupply = User::find($updateUserUserDTO['id']);
        // if ($studentSupply->password != Hash::make($updateUserUserDTO['current_password'])) {
        //     throw new \Exception('Current password is incorrect');
        // }
        // var_dump(User::find($updateUserUserDTO['id']));

        // System Data Validation
        $updateUserSystemDTO = UpdateUserSystemDTO::validate($system_data);

        // Final Data Validation
        $updateUserDTO = UpdateUserDTO::validate(array_merge($updateUserUserDTO, $updateUserSystemDTO));

        // Save In Database
        // User::where('id', $updateUserUserDTO['id'])->update($updateUserDTO);
        $studentSupply = User::find($updateUserUserDTO['id']);

        return $studentSupply;
    }
}
