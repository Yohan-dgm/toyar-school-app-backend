<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetStudentAttendanceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // StudentAttendance Data Validation
            $getStudentAttendanceListDataUserDTO = GetStudentAttendanceListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $student_attendanceListData = GetStudentAttendanceListDataAction::run($getStudentAttendanceListDataUserDTO, $actionData);
            $data["student_attendance_count"] = DB::table("student_attendance")->count();
            // After Intent

            // Return Response
            return array_merge($student_attendanceListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetStudentAttendanceListDataResDTO = GetStudentAttendanceListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetStudentAttendanceListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
