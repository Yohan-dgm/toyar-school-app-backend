<?php

namespace Modules\AccountManagement\Intents\ReceivableAccount\CreateReceivableAccount;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceivableAccount;

class CreateReceivableAccountAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createReceivableAccountUserDTO = CreateReceivableAccountUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createReceivableAccountSystemDTO = CreateReceivableAccountSystemDTO::validate($system_data);
        // Final Data Validation
        $createReceivableAccountDTO = CreateReceivableAccountDTO::validate(array_merge($createReceivableAccountUserDTO, $createReceivableAccountSystemDTO));

        // Save In Database
        $receivableAccount = ReceivableAccount::create($createReceivableAccountDTO);

        return $receivableAccount;
    }
}
