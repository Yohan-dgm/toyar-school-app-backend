<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;

class EditStudentAttendanceIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $editStudentAttendanceUserDTO = EditStudentAttendanceUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            if ($editStudentAttendanceUserDTO['attendance_type_id'] == 4) {
                $studentAtttendanOldData = DB::table("student_attendance")->where('date', $editStudentAttendanceUserDTO['date'])
                    ->where('student_id', $editStudentAttendanceUserDTO['student_id'])
                    ->whereNot('id', $editStudentAttendanceUserDTO['student_attendance_id'])->select('id')->get()->toArray();

                if (count($studentAtttendanOldData) > 0) {
                    foreach ($studentAtttendanOldData as $studentAtttendanOldData_list) {
                        StudentAttendance::where('id', '=', $studentAtttendanOldData_list->id)->delete();
                    }
                }
            }
            // Action 1
            $actionData = [];
            $actionData['updated_by'] = $request->user()->id;

            $attendance = EditStudentAttendanceAction::run($editStudentAttendanceUserDTO, $actionData);

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
