<?php

namespace Modules\AccountManagement\Intents\IncomeNote\UpdateIncomeNote;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeNote;

class UpdateIncomeNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateIncomeNoteUserDTO = UpdateIncomeNoteUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateIncomeNoteSystemDTO = UpdateIncomeNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $updateIncomeNoteDTO = UpdateIncomeNoteDTO::validate(array_merge($updateIncomeNoteUserDTO, $updateIncomeNoteSystemDTO));

        // Save In Database
        IncomeNote::where('id', $updateIncomeNoteUserDTO['id'])->update($updateIncomeNoteDTO);
        $incomeNote = IncomeNote::find($updateIncomeNoteUserDTO['id']);

        return $incomeNote;
    }
}
