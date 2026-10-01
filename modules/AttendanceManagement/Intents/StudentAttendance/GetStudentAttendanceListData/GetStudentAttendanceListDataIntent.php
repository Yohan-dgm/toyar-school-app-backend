<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;

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
            if ($getStudentAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                $data['student_attendance_count'] = StudentAttendance::where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])
                    ->count();
                $data['present_student_count'] = StudentAttendance::where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])
                    ->where('attendance_type_id', 1)
                    ->distinct('student_id')
                    ->count();
                $data['absent_student_count'] = StudentAttendance::where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])
                    ->where('attendance_type_id', 4)
                    ->distinct('student_id')
                    ->count();
            } else {
                $data['student_attendance_count'] = StudentAttendance::where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])
                    // ->whereHas('student.grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //     $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                    // })
                    ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                        $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                    })
                    ->count();
                $data['present_student_count'] = StudentAttendance::where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])
                    ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                        $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                    })
                    // ->whereHas('student.grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //     $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                    // })
                    ->where('attendance_type_id', 1)
                    ->distinct('student_id')
                    ->count();
                $data['absent_student_count'] = StudentAttendance::where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])
                    ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                        $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                    })
                    // ->whereHas('student.grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //     $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                    // })
                    ->where('attendance_type_id', 4)
                    ->distinct('student_id')
                    ->count();
            }
            // $data["attendance_type_list_with_count"] = StudentAttendance::count();
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
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetStudentAttendanceListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
