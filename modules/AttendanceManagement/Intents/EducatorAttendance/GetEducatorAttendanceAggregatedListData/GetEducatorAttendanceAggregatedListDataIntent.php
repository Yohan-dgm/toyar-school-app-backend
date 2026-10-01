<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceAggregatedListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\GradeLevelClass;

class GetEducatorAttendanceAggregatedListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // EducatorAttendance Data Validation
            $getEducatorAttendanceListDataUserDTO = GetEducatorAttendanceAggregatedListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $educatorAttendanceAggregatedListData = GetEducatorAttendanceAggregatedListDataAction::run($getEducatorAttendanceListDataUserDTO, $actionData);
            $data['educator_attendance_count'] = DB::table('educator_attendance')->count();
            $data['grade_level_class_list'] = GradeLevelClass::select('id', 'name', 'grade_level_id')
                ->with(['grade_level' => function (Builder $grade_level_query) {
                    //
                    $grade_level_query->select('id', 'name');
                }])
                ->orderBy('id', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($educatorAttendanceAggregatedListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetEducatorAttendanceAggregatedListDataResDTO = GetEducatorAttendanceAggregatedListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetEducatorAttendanceAggregatedListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
