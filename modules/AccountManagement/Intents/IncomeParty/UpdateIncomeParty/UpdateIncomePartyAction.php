<?php

namespace Modules\AccountManagement\Intents\IncomeParty\UpdateIncomeParty;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeParty;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class UpdateIncomePartyAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateIncomePartyUserDTO = UpdateIncomePartyUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        if ($updateIncomePartyUserDTO['income_party_type'] == 'Person') {
            $personTitle = PersonTitle::find($updateIncomePartyUserDTO['person_title_id']);
            $system_data['name_with_title'] = $personTitle->name.' '.$updateIncomePartyUserDTO['name'];
        } elseif ($updateIncomePartyUserDTO['income_party_type'] == 'Organization') {
            $updateIncomePartyUserDTO['person_title_id'] = null;
            $system_data['name_with_title'] = 'M/s. '.$updateIncomePartyUserDTO['name'];
        }

        if ($updateIncomePartyUserDTO['email'] == null) {
            $system_data['email'] = null;
        }

        // System Data Validation
        $updateIncomePartySystemDTO = UpdateIncomePartySystemDTO::validate($system_data);

        // Final Data Validation
        $updateIncomePartyDTO = UpdateIncomePartyDTO::validate(array_merge($updateIncomePartyUserDTO, $updateIncomePartySystemDTO));

        // Save In Database
        IncomeParty::where('id', $updateIncomePartyUserDTO['id'])->update($updateIncomePartyDTO);
        $updatedIncomeParty = IncomeParty::find($updateIncomePartyUserDTO['id']);

        return $updatedIncomeParty;
    }
}
