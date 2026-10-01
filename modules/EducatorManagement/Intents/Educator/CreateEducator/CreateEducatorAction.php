<?php

namespace Modules\EducatorManagement\Intents\Educator\CreateEducator;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\Educator;
use Modules\EmployeeManagement\Intents\Employee\CreateEmployee\CreateEmployeeAction;
use Modules\EmployeeManagement\Intents\Employee\CreateEmployee\CreateEmployeeUserDTO;

class CreateEducatorAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEducatorUserDTO = CreateEducatorUserDTO::validate($payloadArray);

        // Data Prep
        //employee
        $createEmployeeUserDTO = CreateEmployeeUserDTO::validate($payloadArray);
        $employee = CreateEmployeeAction::run($createEmployeeUserDTO, $actionData);

        $system_data = [];
        $system_data = [
            'created_by' => $actionData['created_by'],
            'is_active' => true,
        ];
        $educatorSystemDto = CreateEducatorSystemDTO::validate($system_data);

        $createEducatorDto = CreateEducatorDTO::validate(array_merge($educatorSystemDto, ['employee_id' => $employee->id, 'educator_grade_id' => $createEducatorUserDTO['educator_grade_id']]));

        // Save In Database
        $educator = Educator::create($createEducatorDto);

        //Save eduacator subject list
        // var_dump($createEducatorUserDTO['educator_subject_list']);
        if ($createEducatorUserDTO['educator_subject_list'] != null) {
            foreach ($createEducatorUserDTO['educator_subject_list'] as $subject) {
                $educator->subject_list()->attach($subject);
            }
        }

        return $educator;
    }

    public function getUniqueFileName($prefix, $path, $extension)
    {
        $count = 1;
        $file = '';
        if (is_null($extension)) {
            $extension = '';
        }
        do {
            if ($count == 1) {
                $file = $prefix.'-'.microtime(true).'.'.$extension;
                $count++;
            } else {
                $file = $prefix.'-'.microtime(true).'_'.$count.'.'.$extension;
                $count++;
            }
        } while (file_exists($path.$file));

        return $file;
    }
}
