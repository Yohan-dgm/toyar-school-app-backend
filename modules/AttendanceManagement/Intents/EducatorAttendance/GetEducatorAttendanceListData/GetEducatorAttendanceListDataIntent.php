<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;

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

            if ($getEducatorAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                $data['educator_attendance_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->count();
                $data['present_educator_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->where('attendance_type_id', 1)
                    ->distinct('educator_id')
                    ->count();
                $data['absent_educator_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->where('attendance_type_id', 4)
                    ->distinct('educator_id')
                    ->count();
                $data['on_leave_educator_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->where('attendance_type_id', 3)
                    ->distinct('educator_id')
                    ->count();
            } else {
                $data['educator_attendance_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->whereHas('educator.grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                        $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                    })
                    ->count();
                $data['present_educator_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->whereHas('educator.grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                        $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                    })
                    ->where('attendance_type_id', 1)
                    ->distinct('educator_id')
                    ->count();
                $data['absent_educator_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->whereHas('educator.grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                        $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                    })
                    ->where('attendance_type_id', 4)
                    ->distinct('educator_id')
                    ->count();
                $data['on_leave_educator_count'] = EducatorAttendance::where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])
                    ->whereHas('educator.grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                        $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                    })
                    ->where('attendance_type_id', 3)
                    ->distinct('educator_id')
                    ->count();
            }

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
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetEducatorAttendanceListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
