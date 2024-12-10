<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance;

use DateTime;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class BulkCreateStudentAttendanceIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $createStudentAttendanceUserDTO = BulkCreateStudentAttendanceUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation
            $studentAttendanceListData = DB::table("student_attendance")->get();

            if (count($studentAttendanceListData) > 0) {
                foreach ($studentAttendanceListData as $studentAttendanceListData_list) {
                    if ($studentAttendanceListData_list->date == $createStudentAttendanceUserDTO['date']) {
                        if ($studentAttendanceListData_list->attendance_type_id == $createStudentAttendanceUserDTO['attendance_type_id']) {
                            DB::rollback();
                            return response()->json(
                                [
                                    "status" => "failed",
                                    "message" => "Attendance already exist",
                                    "data" => null,
                                    "metadata" => null,
                                ],
                                500
                            );
                        }
                    }
                }
            }

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;

            $attendance = BulkCreateStudentAttendanceAction::run($createStudentAttendanceUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $attendance;
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
