<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;

class EditStudentAttendanceAction
{
    use AsAction;
    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $editStudentAttendanceUserDTO = EditStudentAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $editStudentAttendanceSystemDTO = EditStudentAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $editStudentAttendanceDTO = EditStudentAttendanceDTO::validate(array_merge($editStudentAttendanceUserDTO, $editStudentAttendanceSystemDTO));

        // Delete In Database
        // find all records for student_id, date
        // delete 
        StudentAttendance::where('student_id', $editStudentAttendanceDTO['student_id'])
            ->where('date', $editStudentAttendanceDTO['date'])->delete();

        // Create In Database
        // if attendace_type == Absent
        // create 1 record - attendace_type_id= absent id, student, date
        if ($editStudentAttendanceDTO['attendance_type'] == 'Absent') {
            $attendanceData = [
                "attendance_type_id" => 4,
                "student_id" =>  $editStudentAttendanceDTO['student_id'],
                "date" => $editStudentAttendanceDTO['date'],
                "updated_by" => $editStudentAttendanceDTO['updated_by'],
                'updated_at' => Carbon::now(),
            ];
            $attendance = StudentAttendance::insert($attendanceData);
            //
        } else if ($editStudentAttendanceDTO['attendance_type'] == 'Present') {
            // if attendace_type == Present
            // create 1 record for In - in_time
            // create 1 record for Out - out_time

            $createStudentAttendanceDataList = [];
            $attendanceData = [
                "time" => $editStudentAttendanceDTO['in_time'],
                "attendance_type_id" => 1,
            ];
            array_push($createStudentAttendanceDataList, $attendanceData);

            $attendanceData = [
                "time" => $editStudentAttendanceDTO['out_time'],
                "attendance_type_id" => 2,
            ];
            array_push($createStudentAttendanceDataList, $attendanceData);

            $createStudentAttendanceDataList = array_map(function ($item) use ($editStudentAttendanceDTO) {
                return array_merge(
                    $item,
                    [
                        "student_id" =>  $editStudentAttendanceDTO['student_id'],
                        "date" => $editStudentAttendanceDTO['date'],
                        "updated_by" => $editStudentAttendanceDTO['updated_by'],
                        'updated_at' => Carbon::now(),
                    ]
                );
            }, $createStudentAttendanceDataList);

            $attendance = StudentAttendance::insert($createStudentAttendanceDataList);
        }

        return $attendance;
    }
}
