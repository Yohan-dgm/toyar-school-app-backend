<?php

namespace Modules\AttendanceManagement\Intents\Leave\CreateLeave;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Intents\Leave\CreateLeave\CreateLeaveUserDTO;
use Modules\AttendanceManagement\Models\Leave;



class CreateLeaveIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $createLeaveUserDTO = CreateLeaveUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation
            $leaveCount = 0;
            if ($createLeaveUserDTO['leave_duration_type'] == "Half-Day" || $createLeaveUserDTO['leave_duration_type'] == "Full-Day") {
                $leaveCount = Leave::where('employee_id',$createLeaveUserDTO['employee_id'])
                // leave_date == leave_date, start, end
                ->where('leave_date',$createLeaveUserDTO['leave_date'])
                ->orWhere('leave_period_start_date', $createLeaveUserDTO['leave_date'])
                ->orWhere('leave_period_end_date', $createLeaveUserDTO['leave_date'])
                ->count();

                // all period type records where start_date < leave_date AND end_date > leave_date
                // then foreach those periods
                $possiblePeriods = Leave::where('employee_id',$createLeaveUserDTO['employee_id'])
                ->where('leave_period_start_date', '>',  $createLeaveUserDTO['leave_date'])
                ->where('leave_period_end_date', '<',  $createLeaveUserDTO['leave_date'])->get();
                foreach ($possiblePeriods as $period) {
                    if(
                        ($period['leave_period_start_date'] > $createLeaveUserDTO['leave_date'])
                        &&
                        ($period['leave_period_end_date'] < $createLeaveUserDTO['leave_date'])
                    ){
                        $leaveCount++;
                    }
                }
            }else if($createLeaveUserDTO['leave_duration_type'] == "Period") {  
                $leaveCount = Leave::where('employee_id',$createLeaveUserDTO['employee_id'])
                // start_date == leave_date
                ->where('leave_date',$createLeaveUserDTO['leave_period_start_date'])
                // end_date == leave_date
                ->orWhere('leave_date',$createLeaveUserDTO['leave_period_end_date'])
                // start_date in period
                ->orWhere(function($query) use($createLeaveUserDTO) {
                    return $query
                    ->where('leave_period_start_date', '>=',$createLeaveUserDTO['leave_period_start_date'])
                    ->where('leave_period_start_date', '<=',$createLeaveUserDTO['leave_period_end_date']);
                })
                // end_date in period
                ->orWhere(function($query) use($createLeaveUserDTO) {
                    return $query
                    ->where('leave_period_end_date', '<=',$createLeaveUserDTO['leave_period_end_date'])
                    ->where('leave_period_end_date', '>=',$createLeaveUserDTO['leave_period_start_date']);
                })
                ->count();
            }
            if($leaveCount > 0){
                return false;
            }

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $leave = CreateLeaveAction::run($createLeaveUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $leave;
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
}
