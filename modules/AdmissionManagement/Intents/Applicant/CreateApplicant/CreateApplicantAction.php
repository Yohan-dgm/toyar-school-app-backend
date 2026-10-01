<?php

namespace Modules\AdmissionManagement\Intents\Applicant\CreateApplicant;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AdmissionManagement\Models\Applicant;

class CreateApplicantAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createApplicantUserDTO = CreateApplicantUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $applicantNumberDigits = Applicant::where(function (Builder $admission_query) {})->max('applicant_number_digits');
        $applicant_number_digits = (int) $applicantNumberDigits + 1;
        $applicant_number_current_year = strval(date('m') > 8 ? date('y') : (date('y') - 1));
        $applicant_number_prefix = 'APP-NY/';
        $applicant_number = $applicant_number_prefix.$applicant_number_current_year.'/'.$applicant_number_digits;

        if ($createApplicantUserDTO['gender'] == 'Male') {
            $full_name_with_title = 'Mr. '.$createApplicantUserDTO['full_name'];
        } elseif ($createApplicantUserDTO['gender'] == 'Female') {
            $full_name_with_title = 'Miss. '.$createApplicantUserDTO['full_name'];
        }
        $system_data = [
            'applicant_number_digits' => $applicant_number_digits,
            'applicant_number_current_year' => $applicant_number_current_year,
            'applicant_number_prefix' => $applicant_number_prefix,
            'applicant_number' => $applicant_number,
            'created_by' => $actionData['created_by'],
            'full_name_with_title' => $full_name_with_title,
        ];

        // System Data Validation
        $createApplicantSystemDTO = CreateApplicantSystemDTO::validate($system_data);
        // Final Data Validation
        $createApplicantDTO = CreateApplicantDTO::validate(array_merge($createApplicantUserDTO, $createApplicantSystemDTO));

        // Save In Database
        $applicant = Applicant::create($createApplicantDTO);

        return $applicant;
    }
}
