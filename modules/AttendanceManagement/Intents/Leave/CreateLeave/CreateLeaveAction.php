<?php

namespace Modules\AttendanceManagement\Intents\Leave\CreateLeave;

use Carbon\Carbon;
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
        $data = [];
        if ($createLeaveUserDTO['leave_duration_type'] == "Full-Day") {
            $data['leave_period_working_days_count'] = 1; 
        }else if($createLeaveUserDTO['leave_duration_type'] == "Half-Day") {
            $data['leave_period_working_days_count'] = 0.5;  
        }else if($createLeaveUserDTO['leave_duration_type'] == "Period") {  
              // Calculate working days (Monday to Friday only)
              $leave_start_date = Carbon::parse($createLeaveUserDTO['leave_period_start_date']);
              $leave_end_date = Carbon::parse($createLeaveUserDTO['leave_period_end_date']);
              $workingDays_count = $this->calculateWorkingDaysCount($leave_start_date, $leave_end_date);
              $data['leave_period_working_days_count'] = $workingDays_count;
        }

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['leave_status_type_id'] = 1;
        $system_data['leave_period_working_days_count'] = $data['leave_period_working_days_count'];
 

        // System Data Validation
        $createLeaveSystemDTO = CreateLeaveSystemDTO::validate($system_data);
        // Final Data Validation
        $createLeaveDTO = CreateLeaveDTO::validate(array_merge($createLeaveUserDTO, $createLeaveSystemDTO, $data));

        // Save In Database
        $leave = Leave::create($createLeaveDTO);

        return $leave;
    }

    private function calculateWorkingDaysCount(Carbon $start, Carbon $end)
    {
        // Calculate total days between start and end dates (inclusive)
        $totalDays = $start->diffInDays($end) + 1;
        
        // Calculate the number of weekend days
        $weekendDays = $this->calculateWeekendDaysCount($start, $end);
        
        // Subtract weekend days from total days
        $workingDays = $totalDays - $weekendDays;
        
        return $workingDays;
    }

    private function calculateWeekendDaysCount(Carbon $start, Carbon $end)
    {
        $weekendDays = 0;
        $currentDate = $start->copy();

        while ($currentDate->lte($end)) {
            // Count Saturday (6) and Sunday (0)
            if ($currentDate->isWeekend()) {
                $weekendDays++;
            }
            $currentDate->addDay();
        }

        return $weekendDays;
    }
}
