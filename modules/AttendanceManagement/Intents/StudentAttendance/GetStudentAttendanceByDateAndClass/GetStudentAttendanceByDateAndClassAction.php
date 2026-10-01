<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByDateAndClass;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class GetStudentAttendanceByDateAndClassAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getStudentAttendanceByDateAndClassUserDTO = GetStudentAttendanceByDateAndClassUserDTO::from($payloadArray);

        // Get all attendance records for the specified date and class
        $attendanceRecords = StudentAttendance::where('date', $getStudentAttendanceByDateAndClassUserDTO->date)
            ->where('grade_level_class_id', $getStudentAttendanceByDateAndClassUserDTO->grade_level_class_id)
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
            ->orderBy('attendance_type_id')
            ->get();

        // Group records by student and process dual-record system
        $studentAttendanceData = [];
        $studentIds = [];

        foreach ($attendanceRecords as $record) {
            $studentId = $record->student_id;
            $studentIds[] = $studentId;

            if (! isset($studentAttendanceData[$studentId])) {
                $studentAttendanceData[$studentId] = [
                    'student_id' => $studentId,
                    'student' => $record->student ? [
                        'full_name' => $record->student->full_name,
                        'full_name_with_title' => $record->student->full_name_with_title,
                        'admission_number' => $record->student->admission_number,
                    ] : null,
                    'date' => $record->date,
                    'attendance_summary' => [
                        'status' => 'unknown',
                        'in_time' => null,
                        'out_time' => null,
                    ],
                    'attendance_records' => [],
                ];
            }

            // Add the individual record
            $studentAttendanceData[$studentId]['attendance_records'][] = [
                'id' => $record->id,
                'attendance_type_id' => $record->attendance_type_id,
                'time' => $record->time,
                'notes' => $record->notes,
                'attendance_type' => $record->attendance_type ? [
                    'id' => $record->attendance_type->id,
                    'name' => $record->attendance_type->name,
                ] : null,
                'attendance_reason' => $record->attendance_reason ? [
                    'id' => $record->attendance_reason->id,
                    'reason' => $record->attendance_reason->reason,
                ] : null,
            ];

            // Process attendance summary based on dual-record system
            switch ($record->attendance_type_id) {
                case 1: // In
                    $studentAttendanceData[$studentId]['attendance_summary']['in_time'] = $record->time;
                    break;
                case 2: // Out
                    $studentAttendanceData[$studentId]['attendance_summary']['out_time'] = $record->time;
                    break;
                case 3: // Leave/Absent
                    $studentAttendanceData[$studentId]['attendance_summary']['status'] = 'absent';
                    $studentAttendanceData[$studentId]['attendance_summary']['in_time'] = $record->time;
                    break;
                case 4: // Other Absent types
                    $studentAttendanceData[$studentId]['attendance_summary']['status'] = 'absent';
                    break;
            }
        }

        // Determine final attendance status for each student
        foreach ($studentAttendanceData as $studentId => &$data) {
            if ($data['attendance_summary']['status'] === 'absent') {
                // Already marked as absent, keep it
                continue;
            }

            $hasIn = ! is_null($data['attendance_summary']['in_time']);
            $hasOut = ! is_null($data['attendance_summary']['out_time']);

            if ($hasIn && $hasOut) {
                $data['attendance_summary']['status'] = 'present';
            } elseif ($hasIn || $hasOut) {
                $data['attendance_summary']['status'] = 'partial';
            } else {
                $data['attendance_summary']['status'] = 'unknown';
            }
        }

        // Convert to indexed array and apply pagination
        $studentAttendanceList = array_values($studentAttendanceData);
        $total = count($studentAttendanceList);

        // Manual pagination
        $page = $getStudentAttendanceByDateAndClassUserDTO->page;
        $pageSize = $getStudentAttendanceByDateAndClassUserDTO->page_size;
        $offset = ($page - 1) * $pageSize;
        $paginatedData = array_slice($studentAttendanceList, $offset, $pageSize);

        // Calculate summary statistics
        $presentCount = 0;
        $absentCount = 0;
        $partialCount = 0;

        foreach ($studentAttendanceList as $studentData) {
            switch ($studentData['attendance_summary']['status']) {
                case 'present':
                    $presentCount++;
                    break;
                case 'absent':
                    $absentCount++;
                    break;
                case 'partial':
                    $partialCount++;
                    break;
            }
        }

        return [
            'attendance_records' => $paginatedData,
            'summary' => [
                'total_students' => $total,
                'present_count' => $presentCount,
                'absent_count' => $absentCount,
                'partial_count' => $partialCount,
                'date' => $getStudentAttendanceByDateAndClassUserDTO->date,
                'grade_level_class_id' => $getStudentAttendanceByDateAndClassUserDTO->grade_level_class_id,
            ],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => (int) ceil($total / $pageSize),
                'per_page' => $pageSize,
                'total' => $total,
                'has_more_pages' => $page * $pageSize < $total,
            ],
        ];
    }
}
