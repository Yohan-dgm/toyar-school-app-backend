<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetEducatorAttendanceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // EducatorAttendance Data Validation
            $getEducatorAttendanceListDataUserDTO = GetEducatorAttendanceListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $educator_attendanceListData = GetEducatorAttendanceListDataAction::run($getEducatorAttendanceListDataUserDTO, $actionData);
            $data["educator_attendance_count"] = DB::table("educator_attendance")->count();
            // After Intent

            // Return Response
            return array_merge($educator_attendanceListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetEducatorAttendanceListDataResDTO = GetEducatorAttendanceListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetEducatorAttendanceListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
