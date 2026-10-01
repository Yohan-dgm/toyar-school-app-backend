<?php

namespace Modules\ProgramManagement\Intents\Program\UpdateProgram;

// use Modules\ProgramManagement\Models\Program;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\Program;

class UpdateProgramAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateProgramUserDTO = UpdateProgramUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateProgramSystemDTO = UpdateProgramSystemDTO::validate($system_data);

        // Final Data Validation
        $updateProgramDTO = UpdateProgramDTO::validate(array_merge($updateProgramUserDTO, $updateProgramSystemDTO));

        // Save In Database
        Program::where('id', $updateProgramUserDTO['id'])->update($updateProgramDTO);
        $program = Program::find($updateProgramUserDTO['id']);

        return $program;
    }
}
