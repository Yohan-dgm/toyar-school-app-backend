<?php

namespace Modules\AdmissionManagement\Intents\Applicant\UpdateApplicant;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AdmissionManagement\Models\Applicant;

class UpdateApplicantAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateApplicantUserDTO = UpdateApplicantUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        if ($updateApplicantUserDTO['gender'] == 'Male') {
            $full_name_with_title = 'Mr. '.$updateApplicantUserDTO['full_name'];
        } elseif ($updateApplicantUserDTO['gender'] == 'Female') {
            $full_name_with_title = 'Miss. '.$updateApplicantUserDTO['full_name'];
        }
        $system_data = [
            'updated_by' => $actionData['updated_by'],
            'full_name_with_title' => $full_name_with_title,
        ];

        // System Data Validation
        $updateApplicantSystemDTO = UpdateApplicantSystemDTO::validate($system_data);
        // Final Data Validation
        $updateApplicantDTO = UpdateApplicantDTO::validate(array_merge($updateApplicantUserDTO, $updateApplicantSystemDTO));

        // Save In Database
        Applicant::where('id', $updateApplicantUserDTO['id'])->update($updateApplicantDTO);

        $applicant = Applicant::where('id', $updateApplicantUserDTO['id'])->get();

        return $applicant;
    }
}
