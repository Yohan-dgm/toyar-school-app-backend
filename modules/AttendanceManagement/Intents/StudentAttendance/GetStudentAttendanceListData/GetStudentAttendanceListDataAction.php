<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class GetStudentAttendanceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // StudentAttendance Data Validation
        $getStudentAttendanceListDataUserDTO = GetStudentAttendanceListDataUserDTO::validate($payloadArray);

        // Action
        $studentListData = Student::where(function (Builder $student_query_group1) use ($getStudentAttendanceListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['group_filter'] != "") {
                if ($getStudentAttendanceListDataUserDTO['group_filter'] == "All") {
                } else {
                }
            }
        })->where(function (Builder $student_query_group2) use ($getStudentAttendanceListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentAttendanceListDataUserDTO) && count($getStudentAttendanceListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentAttendanceListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $student_query_group3) use ($getStudentAttendanceListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['search_phrase'] != "") {
                $student_query_group3->where("full_name", "ILIKE", "%" . $getStudentAttendanceListDataUserDTO['search_phrase'] . "%");
            }
        })->where(function (Builder $student_query_group4) use ($getStudentAttendanceListDataUserDTO) {

            $student_query_group4->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
                $student_attendance_list_query->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
            });
        })
            ->with(['student_attendance_list' => function (Builder $student_attendance_list_query) {
                //
                $student_attendance_list_query->with(['attendance_type' => function (Builder $attendance_type_query) {
                    //
                    $attendance_type_query->select("attendance_type.id", "attendance_type.name");
                }])->select("id", "date", "time", "student_id", "attendance_type_id");
            }])

            ->select(
                "id",
                "full_name",
            )
            ->orderBy("id", "desc")
            ->paginate(
                $perPage = $getStudentAttendanceListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentAttendanceListDataUserDTO["page"]
            );
        return $studentListData;
    }
}
