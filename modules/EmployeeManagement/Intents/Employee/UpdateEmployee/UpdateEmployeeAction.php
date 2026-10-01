<?php

namespace Modules\EmployeeManagement\Intents\Employee\UpdateEmployee;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\EmployeeAttachment;
use Modules\EmployeeManagement\Models\Employee;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class UpdateEmployeeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEmployeeUserDTO = UpdateEmployeeUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $person_title = PersonTitle::find($updateEmployeeUserDTO['person_title_id']);
        $full_name_with_title = $person_title['name'].$updateEmployeeUserDTO['full_name'];

        $system_data = [];
        $system_data = [
            'updated_by' => $actionData['updated_by'],
            'full_name_with_title' => $full_name_with_title,
            'remaining_annual_leaves' => 14,
            'remaining_medical_leaves' => 7,
            'remaining_maternity_leaves' => 0,
        ];

        // System Data Validation
        $updateEmployeeSystemDTO = UpdateEmployeeSystemDTO::validate($system_data);
        // Final Data Validation
        $updateEmployeeDTO = UpdateEmployeeDTO::validate(array_merge($updateEmployeeUserDTO, $updateEmployeeSystemDTO));

        // Save In Database
        $employee_id = $updateEmployeeDTO['employee_id'];
        unset($updateEmployeeDTO['employee_id']);
        $employee1 = Employee::where('id', $employee_id)->update($updateEmployeeDTO);

        $employee = Employee::where('id', $employee_id)->first();

        if (! is_null($actionData['educator_unsaved_attachment_list']) && count($actionData['educator_unsaved_attachment_list']) > 0) {
            foreach ($actionData['educator_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/employee-management/employee/$employee->employee_number_digits/";
                $data = [];
                $data['employee_id'] = $employee->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($employee->employee_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['updated_by'] = $actionData['updated_by'];
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
