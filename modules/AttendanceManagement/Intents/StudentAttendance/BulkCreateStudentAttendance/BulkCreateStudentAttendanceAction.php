<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class BulkCreateStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentAttendanceUserDTO = BulkCreateStudentAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createStudentAttendanceSystemDTO = BulkCreateStudentAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $createStudentAttendanceDTO = BulkCreateStudentAttendanceDTO::validate(array_merge($createStudentAttendanceUserDTO, $createStudentAttendanceSystemDTO));

        $studentListData = Student::where(function (Builder $student_query_group1) use ($createStudentAttendanceUserDTO) {
            //
            $student_query_group1->where('grade_level_class_id', $createStudentAttendanceUserDTO['grade_level_class_id']);
        })->select("id")->get();

        $createStudentAttendanceDataList = [];
        foreach ($studentListData as $studentListData_list) {
            $attendanceData = [
                "student_id" => $studentListData_list->id,
                "date" => $createStudentAttendanceDTO['date'],
                "time" => $createStudentAttendanceDTO['time'],
                "attendance_type_id" => $createStudentAttendanceDTO['attendance_type_id'],
                "created_by" => $createStudentAttendanceDTO['created_by'],
            ];
            array_push($createStudentAttendanceDataList, $attendanceData);
        }

        // Save In Database
        $createStudentAttendanceDataList = array_map(function ($item) {
            return array_merge(
                $item,
                [
                    'created_at' => Carbon::now(),
                ]
            );
        }, $createStudentAttendanceDataList);

        $attendance = StudentAttendance::insert($createStudentAttendanceDataList);

        return $attendance;
    }
}
