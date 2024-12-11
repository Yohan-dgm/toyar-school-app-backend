<?php

namespace Modules\AttendanceManagement\Intents\Leave\CreateLeave;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\Leave;

class CreateLeaveAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createLeaveUserDTO = CreateLeaveUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['leave_status_type_id'] = $actionData['leave_status_type_id'];
        $system_data['leave_period_working_days_count'] = $actionData['leave_period_working_days_count'];
 

        // System Data Validation
        $createLeaveSystemDTO = CreateLeaveSystemDTO::validate($system_data);
        // Final Data Validation
        $createLeaveDTO = CreateLeaveDTO::validate(array_merge($createLeaveUserDTO, $createLeaveSystemDTO));

        // Save In Database
        $user = Leave::create($createLeaveDTO);

        return $user;
    }
}
