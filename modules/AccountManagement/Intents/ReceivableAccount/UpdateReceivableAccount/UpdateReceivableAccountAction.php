<?php

namespace Modules\AccountManagement\Intents\ReceivableAccount\UpdateReceivableAccount;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceivableAccount;

class UpdateReceivableAccountAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateReceivableAccountUserDTO = UpdateReceivableAccountUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateReceivableAccountSystemDTO = UpdateReceivableAccountSystemDTO::validate($system_data);
        // Final Data Validation

        $updateReceivableAccountDTO = UpdateReceivableAccountDTO::validate(array_merge($updateReceivableAccountUserDTO, $updateReceivableAccountSystemDTO));
        // Save In Database
        ReceivableAccount::where('id', $updateReceivableAccountUserDTO['id'])->update($updateReceivableAccountDTO);
        $receivable_account = ReceivableAccount::find($updateReceivableAccountUserDTO['id']);

        return $receivable_account;
    }
}
