<?php

namespace Modules\DisciplineManagement\Intents\MisconductLevel\CreateMisconductLevel;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineMisconductLevel;

class CreateMisconductLevelAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createMisconductLevelUserDTO = CreateMisconductLevelUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createMisconductLevelSystemDTO = CreateMisconductLevelSystemDTO::validate($system_data);

        // Final Data Validation
        $createMisconductLevelDTO = CreateMisconductLevelDTO::validate(array_merge($createMisconductLevelUserDTO, $createMisconductLevelSystemDTO));

        $misconductLevel = DisciplineMisconductLevel::create($createMisconductLevelDTO);

        return $misconductLevel;
    }
}
