<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class BulkCreateStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $bulkCreateStudentAttendanceUserDTO = BulkCreateStudentAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['grade_level_class_id'] = $actionData['grade_level_class_id'];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createStudentAttendanceSystemDTO = BulkCreateStudentAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $createStudentAttendanceDTO = BulkCreateStudentAttendanceDTO::validate(array_merge($bulkCreateStudentAttendanceUserDTO, $createStudentAttendanceSystemDTO));

        // Use student_list from payload if provided, otherwise get all students from the class
        if (isset($createStudentAttendanceDTO['student_list']) && is_array($createStudentAttendanceDTO['student_list'])) {
            $studentIds = $createStudentAttendanceDTO['student_list'];
            $studentListData = Student::whereIn('id', $studentIds)
                ->where('has_dropped_out', false)
                ->where('is_school_leaver', false)
                ->select('id', 'grade_level_class_id')
                ->get();
        } else {
            $studentListData = Student::where('has_dropped_out', false)
                ->where('is_school_leaver', false)
                ->where('grade_level_class_id', $system_data['grade_level_class_id'])
                ->select('id', 'grade_level_class_id')
                ->get();
        }

        $createStudentAttendanceDataList = [];
        foreach ($studentListData as $studentListData_list) {
            $attendanceData = [
                'student_id' => $studentListData_list->id,
                'grade_level_class_id' => $studentListData_list->grade_level_class_id,
                'date' => $createStudentAttendanceDTO['date'],
                'time' => $createStudentAttendanceDTO['in_time'],
                'attendance_type_id' => 1,
            ];
            array_push($createStudentAttendanceDataList, $attendanceData);

            $attendanceData = [
                'student_id' => $studentListData_list->id,
                'grade_level_class_id' => $studentListData_list->grade_level_class_id,
                'date' => $createStudentAttendanceDTO['date'],
                'time' => $createStudentAttendanceDTO['out_time'],
                'attendance_type_id' => 2,
            ];
            array_push($createStudentAttendanceDataList, $attendanceData);
        }

        // Save In Database
        $createStudentAttendanceDataList = array_map(function ($item) use ($createStudentAttendanceDTO) {
            return array_merge(
                $item,
                [
                    'created_by' => $createStudentAttendanceDTO['created_by'],
                    'created_at' => Carbon::now(),
                ]
            );
        }, $createStudentAttendanceDataList);

        StudentAttendance::insert($createStudentAttendanceDataList);

        return ['grade_level_class_name' => $bulkCreateStudentAttendanceUserDTO['grade_level_class_name']];
    }
}
