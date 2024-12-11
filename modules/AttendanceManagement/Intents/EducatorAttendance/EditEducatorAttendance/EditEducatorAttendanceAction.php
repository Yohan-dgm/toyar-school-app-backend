<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\EditEducatorAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;

class EditEducatorAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $editEducatorAttendanceUserDTO = EditEducatorAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $editEducatorAttendanceSystemDTO = EditEducatorAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $editEducatorAttendanceDTO = EditEducatorAttendanceDTO::validate(array_merge($editEducatorAttendanceUserDTO, $editEducatorAttendanceSystemDTO));
        
        unset($editEducatorAttendanceDTO['educator_attendance_id']);

        // edit In Database
        $educatorAttendance = EducatorAttendance::where('id', $editEducatorAttendanceUserDTO['educator_attendance_id'])->first();
        $educatorAttendance->update($editEducatorAttendanceDTO);

        return $educatorAttendance;
    }
}
