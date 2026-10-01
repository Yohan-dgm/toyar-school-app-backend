<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendance;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class GetTodayStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getTodayStudentAttendanceUserDTO = GetTodayStudentAttendanceUserDTO::validate($payloadArray);

        $today = Carbon::today()->format('Y-m-d');

        $studentsQuery = Student::query()
            ->select('id', 'full_name', 'full_name_with_title', 'admission_number', 'grade_level_class_id');

        if ($getTodayStudentAttendanceUserDTO->grade_level_class_id) {
            $studentsQuery->where('grade_level_class_id', $getTodayStudentAttendanceUserDTO->grade_level_class_id);
        }

        $students = $studentsQuery->get();

        $attendanceRecords = StudentAttendance::where('date', $today)
            ->when($getTodayStudentAttendanceUserDTO->grade_level_class_id, function (Builder $query) use ($getTodayStudentAttendanceUserDTO) {
                return $query->where('grade_level_class_id', $getTodayStudentAttendanceUserDTO->grade_level_class_id);
            })
            ->with([
                'student' => function (Builder $studentQuery) {
                    $studentQuery->select('id', 'full_name', 'full_name_with_title', 'admission_number');
                },
                'attendance_type' => function (Builder $attendanceTypeQuery) {
                    $attendanceTypeQuery->select('id', 'name');
                },
                'attendance_reason' => function (Builder $attendanceReasonQuery) {
                    $attendanceReasonQuery->select('id', 'attendance_id', 'reason');
                },
            ])
            ->select('id', 'student_id', 'grade_level_class_id', 'date', 'time', 'attendance_type_id', 'notes')
            ->orderBy('student_id')
            ->get()
            ->keyBy('student_id');

        $studentAttendanceData = [];
        $presentCount = 0;
        $absentCount = 0;
        $lateCount = 0;

        foreach ($students as $student) {
            $attendanceRecord = $attendanceRecords->get($student->id);
            $attendanceStatus = 'absent'; // Default status
            $attendanceTypeId = 4; // Default to absent type
            $time = null;
            $notes = null;
            $attendanceType = null;
            $attendanceReason = null;

            if ($attendanceRecord) {
                switch ($attendanceRecord->attendance_type_id) {
                    case 1:
                        $attendanceStatus = 'present';
                        $presentCount++;
                        break;
                    case 4:
                        $attendanceStatus = 'absent';
                        $absentCount++;
                        break;
                    default:
                        $attendanceStatus = 'late';
                        $lateCount++;
                        break;
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
            } else {
                $absentCount++;
            }

            $studentAttendanceData[] = [
                'student_id' => $student->id,
                'student' => [
                    'full_name' => $student->full_name,
                    'full_name_with_title' => $student->full_name_with_title,
                    'admission_number' => $student->admission_number,
                ],
                'date' => $today,
                'attendance_status' => $attendanceStatus,
                'attendance_type_id' => $attendanceTypeId,
                'time' => $time,
                'notes' => $notes,
                'attendance_type' => $attendanceType,
                'attendance_reason' => $attendanceReason,
            ];
        }

        $totalStudents = count($studentAttendanceData);

        $page = $getTodayStudentAttendanceUserDTO->page;
        $pageSize = $getTodayStudentAttendanceUserDTO->page_size;
        $offset = ($page - 1) * $pageSize;
        $paginatedData = array_slice($studentAttendanceData, $offset, $pageSize);

        return [
            'attendance_records' => $paginatedData,
            'summary' => [
                'total_students' => $totalStudents,
                'present_count' => $presentCount,
                'absent_count' => $absentCount,
                'late_count' => $lateCount,
                'date' => $today,
                'grade_level_class_id' => $getTodayStudentAttendanceUserDTO->grade_level_class_id,
            ],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => (int) ceil($totalStudents / $pageSize),
                'per_page' => $pageSize,
                'total' => $totalStudents,
                'has_more_pages' => $page * $pageSize < $totalStudents,
            ],
        ];
    }
}
