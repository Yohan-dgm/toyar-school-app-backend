<?php

namespace Modules\AttendanceManagement\Intents\EducatorLeave\CreateEducatorLeave;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\Leave;

class CreateEducatorLeaveAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEducatorLeaveUserDTO = CreateEducatorLeaveUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['leave_status_type_id'] = $actionData['leave_status_type_id'];
        $system_data['leave_period_working_days_count'] = $actionData['leave_period_working_days_count'];
 

        // System Data Validation
        $createEducatorLeaveSystemDTO = CreateEducatorLeaveSystemDTO::validate($system_data);
        // Final Data Validation
        $createEducatorLeaveDTO = CreateEducatorLeaveDTO::validate(array_merge($createEducatorLeaveUserDTO, $createEducatorLeaveSystemDTO));

        // Save In Database
        $user = Leave::create($createEducatorLeaveDTO);

        return $user;
    }
}
