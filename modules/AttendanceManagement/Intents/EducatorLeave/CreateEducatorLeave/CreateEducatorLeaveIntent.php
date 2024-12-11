<?php

namespace Modules\AttendanceManagement\Intents\EducatorLeave\CreateEducatorLeave;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Intents\EducatorLeave\CreateEducatorLeave\CreateEducatorLeaveUserDTO;



class CreateEducatorLeaveIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $createEducatorLeaveUserDTO = CreateEducatorLeaveUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $actionData['leave_type'] = $request->leave_type;
            $actionData['leave_status_type_id'] = 1;
             
            if ($request->leave_duration_type == "Full-Day") {
                $actionData['leave_period_working_days_count'] = 1; 
            }else if($request->leave_duration_type == "Half-Day") {
                $actionData['leave_period_working_days_count'] = 0.5;  
            }else if($request->leave_duration_type == "Period") { 
              
                  // Calculate working days (Monday to Friday only)
                  $leave_start_date = Carbon::parse($request->leave_period_start_date);
                  $leave_end_date = Carbon::parse($request->leave_period_end_date);
                  
                  $workingDays_count = $this->calculateWorkingDays($leave_start_date, $leave_end_date);
 
                  $actionData['leave_period_working_days_count'] = $workingDays_count;

            }


            $Leave = CreateEducatorLeaveAction::run($createEducatorLeaveUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $Leave;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        "status" => "successful",
                        "message" => "",
                        "data" => $result,
                        "metadata" => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        "status" => "failed",
                        "message" => "",
                        "data" => null,
                        "metadata" => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function calculateWorkingDays(Carbon $start, Carbon $end)
    {
        // Calculate total days between start and end dates (inclusive)
        $totalDays = $start->diffInDays($end) + 1;
        
        // Calculate the number of weekend days
        $weekendDays = $this->countWeekendDays($start, $end);
        
        // Subtract weekend days from total days
        $workingDays = $totalDays - $weekendDays;
        
        return $workingDays;
    }


private function countWeekendDays(Carbon $start, Carbon $end)
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
