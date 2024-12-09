<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;

class CreateStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentAttendanceUserDTO = CreateStudentAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createStudentAttendanceSystemDTO = CreateStudentAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $createStudentAttendanceDTO = CreateStudentAttendanceDTO::validate(array_merge($createStudentAttendanceUserDTO, $createStudentAttendanceSystemDTO));

        // Save In Database
        $user = StudentAttendance::create($createStudentAttendanceDTO);

        return $user;
    }
}
