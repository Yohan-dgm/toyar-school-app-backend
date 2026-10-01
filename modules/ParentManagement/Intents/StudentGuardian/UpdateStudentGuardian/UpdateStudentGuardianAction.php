<?php

namespace Modules\ParentManagement\Intents\StudentGuardian\UpdateStudentGuardian;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ParentManagement\Models\StudentGuardian;

class UpdateStudentGuardianAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateStudentGuardianUserDTO = UpdateStudentGuardianUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateStudentGuardianSystemDTO = UpdateStudentGuardianSystemDTO::validate($system_data);

        // Final Data Validation
        $updateStudentGuardianDTO = UpdateStudentGuardianDTO::validate(array_merge($updateStudentGuardianUserDTO, $updateStudentGuardianSystemDTO));

        // Save In Database
        StudentGuardian::where('id', $updateStudentGuardianUserDTO['id'])->update($updateStudentGuardianDTO);
        $studentGuardian = StudentGuardian::find($updateStudentGuardianUserDTO['id']);

        return $studentGuardian;
    }
}
