<?php

namespace Modules\ParentManagement\Intents\StudentGuardian\CreateStudentGuardian;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ParentManagement\Models\StudentGuardian;

class CreateStudentGuardianAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentGuardianUserDTO = CreateStudentGuardianUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createStudentGuardianSystemDTO = CreateStudentGuardianSystemDTO::validate($system_data);

        // Final Data Validation
        $createStudentGuardianDTO = CreateStudentGuardianDTO::validate(array_merge($createStudentGuardianUserDTO, $createStudentGuardianSystemDTO));

        // Save In Database
        $createStudentGuardian = StudentGuardian::create($createStudentGuardianDTO);

        return $createStudentGuardian;
    }
}
