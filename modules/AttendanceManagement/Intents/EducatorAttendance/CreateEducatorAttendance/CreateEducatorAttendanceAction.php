<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\CreateEducatorAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;

class CreateEducatorAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEducatorAttendanceUserDTO = CreateEducatorAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createEducatorAttendanceSystemDTO = CreateEducatorAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $createEducatorAttendanceDTO = CreateEducatorAttendanceDTO::validate(array_merge($createEducatorAttendanceUserDTO, $createEducatorAttendanceSystemDTO));

        // Save In Database
        $user = EducatorAttendance::create($createEducatorAttendanceDTO);

        return $user;
    }
}
