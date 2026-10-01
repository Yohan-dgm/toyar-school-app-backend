<?php

namespace Modules\AccountManagement\Intents\ExpenseParty\UpdateExpenseParty;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseParty;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class UpdateExpensePartyAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExpensePartyUserDTO = UpdateExpensePartyUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        if ($updateExpensePartyUserDTO['expense_party_type'] == 'Person') {
            $personTitle = PersonTitle::find($updateExpensePartyUserDTO['person_title_id']);
            $system_data['name_with_title'] = $personTitle->name.' '.$updateExpensePartyUserDTO['name'];
        } elseif ($updateExpensePartyUserDTO['expense_party_type'] == 'Organization') {
            $updateExpensePartyUserDTO['person_title_id'] = null;
            $system_data['name_with_title'] = 'M/s. '.$updateExpensePartyUserDTO['name'];
        }

        if ($updateExpensePartyUserDTO['email'] == null) {
            $system_data['email'] = null;
        }

        // System Data Validation
        $updateExpensePartySystemDTO = UpdateExpensePartySystemDTO::validate($system_data);

        // Final Data Validation
        $updateExpensePartyDTO = UpdateExpensePartyDTO::validate(array_merge($updateExpensePartyUserDTO, $updateExpensePartySystemDTO));

        // Save In Database
        ExpenseParty::where('id', $updateExpensePartyUserDTO['id'])->update($updateExpensePartyDTO);
        $updatedExpenseParty = ExpenseParty::find($updateExpensePartyUserDTO['id']);

        return $updatedExpenseParty;
    }
}
