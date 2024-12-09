<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance;

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
        unset($editStudentAttendanceDTO['student_attendance_id']);

        // edit In Database
        $studentAttendance = StudentAttendance::where('id', $editStudentAttendanceUserDTO['student_attendance_id'])->first();
        $studentAttendance->update($editStudentAttendanceDTO);

        return $studentAttendance;
    }
}
