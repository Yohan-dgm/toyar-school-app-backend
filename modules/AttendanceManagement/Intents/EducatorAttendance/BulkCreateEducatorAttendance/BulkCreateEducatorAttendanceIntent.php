<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\BulkCreateEducatorAttendance;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;

class BulkCreateEducatorAttendanceIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $createEducatorAttendanceUserDTO = BulkCreateEducatorAttendanceUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation
            $educatorAtttendanceCount = EducatorAttendance::where('date', $createEducatorAttendanceUserDTO['date'])->count();

            if ($educatorAtttendanceCount > 0) { // previous Bulk Create existing
                // return
                DB::rollback();
                return false;
            }

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $attendance = BulkCreateEducatorAttendanceAction::run($createEducatorAttendanceUserDTO, $actionData);

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
                        "message" => "Attendance already exist",
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
