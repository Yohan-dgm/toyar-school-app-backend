<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\ProgramManagement\Models\GradeLevelClass;

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
            $gradeLevelClass = GradeLevelClass::where('name', $createStudentAttendanceUserDTO['grade_level_class_name'])->first();
            $studentAtttendanceCount = StudentAttendance::whereHas('student', function (Builder $student_query) use ($gradeLevelClass) {
                return $student_query->where('grade_level_class_id', $gradeLevelClass->id);
            })->where('date', $createStudentAttendanceUserDTO['date'])->count();

            if ($studentAtttendanceCount > 0) { // previous Bulk Create existing
                // return
                DB::rollback();

                return false;
            }

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $actionData['grade_level_class_id'] = $gradeLevelClass->id;
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
                        'status' => 'successful',
                        'message' => '',
                        'data' => $result,
                        'metadata' => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Attendance already exist',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
