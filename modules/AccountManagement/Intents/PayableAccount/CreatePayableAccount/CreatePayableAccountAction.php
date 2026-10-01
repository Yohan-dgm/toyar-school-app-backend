<?php

namespace Modules\AccountManagement\Intents\PayableAccount\CreatePayableAccount;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PayableAccount;

class CreatePayableAccountAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createPayableAccountUserDTO = CreatePayableAccountUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createPayableAccountSystemDTO = CreatePayableAccountSystemDTO::validate($system_data);
        // Final Data Validation
        $createPayableAccountDTO = CreatePayableAccountDTO::validate(array_merge($createPayableAccountUserDTO, $createPayableAccountSystemDTO));

        // Save In Database
        $payableAccount = PayableAccount::create($createPayableAccountDTO);

        return $payableAccount;
    }
}
