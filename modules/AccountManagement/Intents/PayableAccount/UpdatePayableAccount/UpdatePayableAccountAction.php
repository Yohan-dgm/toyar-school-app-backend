<?php

namespace Modules\AccountManagement\Intents\PayableAccount\UpdatePayableAccount;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PayableAccount;

class UpdatePayableAccountAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updatePayableAccountUserDTO = UpdatePayableAccountUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updatePayableAccountSystemDTO = UpdatePayableAccountSystemDTO::validate($system_data);
        // Final Data Validation

        $updatePayableAccountDTO = UpdatePayableAccountDTO::validate(array_merge($updatePayableAccountUserDTO, $updatePayableAccountSystemDTO));
        // Save In Database
        PayableAccount::where('id', $updatePayableAccountUserDTO['id'])->update($updatePayableAccountDTO);
        $payable_account = PayableAccount::find($updatePayableAccountUserDTO['id']);

        return $payable_account;
    }
}
