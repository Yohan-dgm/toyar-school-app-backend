<?php

namespace Modules\EducatorManagement\Intents\Educator\UpdateEducator;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\Educator;
use Modules\EmployeeManagement\Intents\Employee\UpdateEmployee\UpdateEmployeeAction;
use Modules\EmployeeManagement\Intents\Employee\UpdateEmployee\UpdateEmployeeUserDTO;

class UpdateEducatorAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEducatorUserDTO = UpdateEducatorUserDTO::validate($payloadArray);

        // Data Prep
        $updateEmployeeUserDTO = UpdateEmployeeUserDTO::validate($payloadArray);
        $employee = UpdateEmployeeAction::run($updateEmployeeUserDTO, $actionData);

        $system_data = [];
        $system_data = [
            'updated_by' => $actionData['updated_by'],
            'is_active' => true,
        ];
        $educatorSystemDto = UpdateEducatorSystemDTO::validate($system_data);

        $updateEducatorDto = UpdateEducatorDTO::validate(array_merge($educatorSystemDto, [
            'id' => $updateEducatorUserDTO['id'],
            'employee_id' => $updateEducatorUserDTO['employee_id'],
            'educator_grade_id' => $updateEducatorUserDTO['educator_grade_id'],
        ]));

        // Save In Database
        Educator::where('id', $updateEducatorUserDTO['id'])->update($updateEducatorDto);
        $educator = Educator::where('id', $updateEducatorUserDTO['id'])->first();
        //Save eduacator subject list
        // var_dump($updateEducatorUserDTO['educator_subject_list']);
        if ($updateEducatorUserDTO['educator_subject_list'] != null) {
            $educator->subject_list()->detach();
            foreach ($updateEducatorUserDTO['educator_subject_list'] as $subject) {
                $educator->subject_list()->attach($subject);
            }
        }

        return $educator;
    }
}
