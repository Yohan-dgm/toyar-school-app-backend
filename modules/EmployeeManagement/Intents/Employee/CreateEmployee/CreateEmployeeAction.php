<?php

namespace Modules\EmployeeManagement\Intents\Employee\CreateEmployee;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\EmployeeAttachment;
use Modules\EmployeeManagement\Models\Employee;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class CreateEmployeeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEmployeeUserDTO = CreateEmployeeUserDTO::validate($payloadArray);

        // Data Prep
        $employeeNumberDigits = Employee::where(function (Builder $employee_query) {})->max('employee_number_digits');

        $employee_number_digits = (int) $employeeNumberDigits + 1;
        $employee_number_current_year = strval(date('m') > 8 ? date('y') : (date('y') - 1));
        $employee_number_prefix = 'NY';
        $employee_number = $employee_number_prefix.$employee_number_current_year.'/'.$employee_number_digits;

        // System Data Prep
        $person_title = PersonTitle::find($createEmployeeUserDTO['person_title_id']);
        $full_name_with_title = $person_title['name'].$createEmployeeUserDTO['full_name'];

        $system_data = [];
        $system_data = [
            'employee_number_digits' => $employee_number_digits,
            'employee_number_current_year' => $employee_number_current_year,
            'employee_number_prefix' => $employee_number_prefix,
            'employee_number' => $employee_number,
            'created_by' => $actionData['created_by'],
            'full_name_with_title' => $full_name_with_title,
            'remaining_annual_leaves' => 14,
            'remaining_medical_leaves' => 7,
            'remaining_maternity_leaves' => 0,
        ];

        // System Data Validation
        $createEmployeeSystemDTO = CreateEmployeeSystemDTO::validate($system_data);
        // Final Data Validation
        $createEmployeeDTO = CreateEmployeeDTO::validate(array_merge($createEmployeeUserDTO, $createEmployeeSystemDTO));

        // Save In Database
        $employee = Employee::create($createEmployeeDTO);

        if (! is_null($actionData['educator_unsaved_attachment_list']) && count($actionData['educator_unsaved_attachment_list']) > 0) {
            foreach ($actionData['educator_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/employee-management/employee/$employee->employee_number_digits/";
                $data = [];
                $data['employee_id'] = $employee->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($employee->employee_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['created_by'];
                EmployeeAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/employee-management/employee/$employee->employee_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        return $employee;
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
