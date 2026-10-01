<?php

namespace Modules\DisciplineManagement\Intents\MisconductLevel\UpdateMisconductLevel;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineMisconductLevel;

class UpdateMisconductLevelAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateMisconductLevelUserDTO = UpdateMisconductLevelUserDTO::validate($payloadArray);

        $misconductLevel = DisciplineMisconductLevel::find($updateMisconductLevelUserDTO['id']);
        if (! $misconductLevel) {
            throw new \Exception('Misconduct level not found');
        }

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateMisconductLevelSystemDTO = UpdateMisconductLevelSystemDTO::validate($system_data);

        // Final Data Validation
        $updateMisconductLevelDTO = UpdateMisconductLevelDTO::validate(array_merge($updateMisconductLevelUserDTO, $updateMisconductLevelSystemDTO));

        DisciplineMisconductLevel::where('id', $updateMisconductLevelUserDTO['id'])->update($updateMisconductLevelDTO);

        return DisciplineMisconductLevel::find($updateMisconductLevelUserDTO['id']);
    }
}
