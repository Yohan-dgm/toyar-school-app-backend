<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendanceByStudentId;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class GetTodayStudentAttendanceByStudentIdAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getTodayStudentAttendanceByStudentIdUserDTO = GetTodayStudentAttendanceByStudentIdUserDTO::validate($payloadArray);

        $today = Carbon::today()->format('Y-m-d');
        $studentId = $getTodayStudentAttendanceByStudentIdUserDTO['student_id'];

        $student = Student::select('id', 'full_name', 'full_name_with_title', 'admission_number', 'grade_level_class_id')
            ->find($studentId);

        if (! $student) {
            throw new \Exception('Student not found');
        }

        $attendanceRecord = StudentAttendance::where('date', $today)
            ->where('student_id', $studentId)
            ->whereIn('attendance_type_id', [1, 4]) // Only present (1) or absent (4)
            ->with([
                'attendance_type' => function (Builder $attendanceTypeQuery) {
                    $attendanceTypeQuery->select('id', 'name');
                },
                'attendance_reason' => function (Builder $attendanceReasonQuery) {
                    $attendanceReasonQuery->select('id', 'attendance_id', 'reason');
                },
            ])
            ->select('id', 'student_id', 'grade_level_class_id', 'date', 'time', 'attendance_type_id', 'notes')
            ->first();

        $attendanceStatus = null; // Default status - null when no data
        $attendanceTypeId = null; // Default to null
        $time = null;
        $notes = null;
        $attendanceType = null;
        $attendanceReason = null;

        if ($attendanceRecord) {
            // Only handle attendance_type_id 1 (present) and 4 (absent)
            if ($attendanceRecord->attendance_type_id == 1) {
                $attendanceStatus = 'present';
            } elseif ($attendanceRecord->attendance_type_id == 4) {
                $attendanceStatus = 'absent';
            }

            $attendanceTypeId = $attendanceRecord->attendance_type_id;
            $time = $attendanceRecord->time;
            $notes = $attendanceRecord->notes;
            $attendanceType = $attendanceRecord->attendance_type ? [
                'id' => $attendanceRecord->attendance_type->id,
                'name' => $attendanceRecord->attendance_type->name,
            ] : null;
            $attendanceReason = $attendanceRecord->attendance_reason ? [
                'id' => $attendanceRecord->attendance_reason->id,
                'reason' => $attendanceRecord->attendance_reason->reason,
            ] : null;
        }

        return [
            'student_id' => $student->id,
            'student' => [
                'full_name_with_title' => $student->full_name_with_title,
            ],
            'date' => $today,
            'attendance_status' => $attendanceStatus,
            'attendance_type_id' => $attendanceTypeId,
            'time' => $time,
            'notes' => $notes,
            // 'attendance_type' => $attendanceType,
            // 'attendance_reason' => $attendanceReason,
        ];
    }
}
