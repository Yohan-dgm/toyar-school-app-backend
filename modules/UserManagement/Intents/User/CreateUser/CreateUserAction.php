<?php

namespace Modules\UserManagement\Intents\User\CreateUser;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\UserManagement\Models\User;

class CreateUserAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createUserUserDTO = CreateUserUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // Final Data Validation
        $createUserDTO = CreateUserDTO::validate(array_merge($createUserUserDTO, $system_data));

        // Save In Database
        $user = User::create($createUserDTO);

        return $user;
    }
}
