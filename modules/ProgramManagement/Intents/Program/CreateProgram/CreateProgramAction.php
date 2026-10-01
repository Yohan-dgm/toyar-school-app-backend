<?php

namespace Modules\AccountManagement\Intents\Program\CreateProgram;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\Program;

class CreateProgramAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createProgramUserDTO = CreateProgramUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createProgramSystemDTO = CreateProgramSystemDTO::validate($system_data);

        // Final Data Validation
        $createProgramDTO = CreateProgramDTO::validate(array_merge($createProgramUserDTO, $createProgramSystemDTO));

        // Save In Database
        $createProgram = Program::create($createProgramDTO);

        return $createProgram;
    }
}
