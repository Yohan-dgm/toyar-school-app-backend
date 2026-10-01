<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\DeleteStudentAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\AttendanceReason;
use Modules\AttendanceManagement\Models\StudentAttendance;

class DeleteStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteStudentAttendanceUserDTO = DeleteStudentAttendanceUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['deleted_by'] = $actionData['deleted_by'] ?? $actionData['created_by'] ?? 1;

        // System Data Validation
        $deleteStudentAttendanceSystemDTO = DeleteStudentAttendanceSystemDTO::validate($system_data);

        // Final Data Validation
        $deleteStudentAttendanceDTO = DeleteStudentAttendanceDTO::validate(array_merge($deleteStudentAttendanceUserDTO, $deleteStudentAttendanceSystemDTO));

        $attendanceRecords = [];
        $deletedCount = 0;

        if (! empty($deleteStudentAttendanceDTO->attendance_id)) {
            // Single record deletion by ID (but still need to match the date)
            $attendanceRecord = StudentAttendance::where('id', $deleteStudentAttendanceDTO->attendance_id)
                ->where('date', $deleteStudentAttendanceDTO->date)
                ->first();

            if (! $attendanceRecord) {
                throw new \Exception('Attendance record not found for the specified ID and date');
            }

            $attendanceRecords = [$attendanceRecord];

        } else {
            // Bulk deletion by date (with optional student_id and/or grade_level_class_id filter)
            $query = StudentAttendance::where('date', $deleteStudentAttendanceDTO->date);

            if (! empty($deleteStudentAttendanceDTO->student_id)) {
                // Delete specific student's attendance for the date
                $query->where('student_id', $deleteStudentAttendanceDTO->student_id);
            }

            if (! empty($deleteStudentAttendanceDTO->grade_level_class_id)) {
                // Delete attendance for specific class on the date
                $query->where('grade_level_class_id', $deleteStudentAttendanceDTO->grade_level_class_id);
            }
            // If no filters provided, delete ALL students' attendance for the date

            $attendanceRecords = $query->get()->toArray();

            if (empty($attendanceRecords)) {
                $errorMessage = 'No attendance records found for the specified filters and date';
                if (! empty($deleteStudentAttendanceDTO->student_id) && ! empty($deleteStudentAttendanceDTO->grade_level_class_id)) {
                    $errorMessage = 'No attendance records found for the specified student, class, and date';
                } elseif (! empty($deleteStudentAttendanceDTO->student_id)) {
                    $errorMessage = 'No attendance records found for the specified student and date';
                } elseif (! empty($deleteStudentAttendanceDTO->grade_level_class_id)) {
                    $errorMessage = 'No attendance records found for the specified class and date';
                } else {
                    $errorMessage = 'No attendance records found for the specified date';
                }
                throw new \Exception($errorMessage);
            }
        }

        $deletedInfo = [];

        // Delete all found attendance records and their reasons
        foreach ($attendanceRecords as $record) {
            if (is_array($record)) {
                $recordId = $record['id'];
                $recordData = $record;
            } else {
                $recordId = $record->id;
                $recordData = [
                    'id' => $record->id,
                    'student_id' => $record->student_id,
                    'date' => $record->date,
                    'time' => $record->time,
                    'attendance_type_id' => $record->attendance_type_id,
                ];
            }

            // Delete associated reasons first
            AttendanceReason::where('attendance_id', $recordId)->delete();

            // Delete the attendance record
            $deleted = StudentAttendance::where('id', $recordId)->delete();

            if ($deleted) {
                $deletedInfo[] = $recordData;
                $deletedCount++;
            }
        }

        if ($deletedCount === 0) {
            throw new \Exception('Failed to delete attendance records');
        }

        // Generate appropriate message based on deletion type
        if (! empty($deleteStudentAttendanceDTO->attendance_id)) {
            $message = 'Attendance record deleted successfully for date '.$deleteStudentAttendanceDTO->date;
        } elseif (! empty($deleteStudentAttendanceDTO->student_id) && ! empty($deleteStudentAttendanceDTO->grade_level_class_id)) {
            $message = $deletedCount === 1
                ? "Student attendance deleted successfully for class and date {$deleteStudentAttendanceDTO->date}"
                : "Student attendance deleted successfully for class and date {$deleteStudentAttendanceDTO->date} ({$deletedCount} records)";
        } elseif (! empty($deleteStudentAttendanceDTO->student_id)) {
            $message = $deletedCount === 1
                ? "Student attendance deleted successfully for date {$deleteStudentAttendanceDTO->date}"
                : "Student attendance deleted successfully for date {$deleteStudentAttendanceDTO->date} ({$deletedCount} records)";
        } elseif (! empty($deleteStudentAttendanceDTO->grade_level_class_id)) {
            $message = "Class attendance deleted successfully for date {$deleteStudentAttendanceDTO->date} ({$deletedCount} records)";
        } else {
            $message = "All attendance records deleted successfully for date {$deleteStudentAttendanceDTO->date} ({$deletedCount} records)";
        }

        return [
            'message' => $message,
            'date' => $deleteStudentAttendanceDTO->date,
            'deleted_attendance' => $deletedInfo,
            'deleted_count' => $deletedCount,
            'deletion_type' => ! empty($deleteStudentAttendanceDTO->attendance_id) ? 'single_record_by_date' :
                              (! empty($deleteStudentAttendanceDTO->student_id) && ! empty($deleteStudentAttendanceDTO->grade_level_class_id) ? 'student_class_date' :
                              (! empty($deleteStudentAttendanceDTO->student_id) ? 'student_date' :
                              (! empty($deleteStudentAttendanceDTO->grade_level_class_id) ? 'class_date' : 'all_date'))),
            'filters_applied' => [
                'attendance_id' => $deleteStudentAttendanceDTO->attendance_id,
                'student_id' => $deleteStudentAttendanceDTO->student_id,
                'grade_level_class_id' => $deleteStudentAttendanceDTO->grade_level_class_id,
            ],
            'deleted_by' => $deleteStudentAttendanceDTO->deleted_by,
        ];
    }
}
