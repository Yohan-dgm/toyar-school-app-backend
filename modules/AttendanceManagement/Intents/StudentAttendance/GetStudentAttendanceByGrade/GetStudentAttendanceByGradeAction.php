<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByGrade;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;

class GetStudentAttendanceByGradeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getStudentAttendanceByGradeUserDTO = GetStudentAttendanceByGradeUserDTO::validate($payloadArray);

        // Get all attendance records for the specified date and class IDs
        $attendanceRecords = StudentAttendance::where('date', $getStudentAttendanceByGradeUserDTO->date)
            ->whereIn('grade_level_class_id', $getStudentAttendanceByGradeUserDTO->grade_level_class_ids)
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
                'grade_level_class' => function (Builder $gradeLevelClassQuery) {
                    $gradeLevelClassQuery->select('id', 'name', 'grade_level_id');
                },
            ])
            ->select('id', 'student_id', 'grade_level_class_id', 'date', 'time', 'attendance_type_id', 'notes')
            ->orderBy('grade_level_class_id')
            ->orderBy('student_id')
            ->orderBy('attendance_type_id')
            ->get();

        // Group records by class, then by student
        $classAttendanceData = [];
        $overallStats = [
            'total_students' => 0,
            'present_count' => 0,
            'absent_count' => 0,
            'partial_count' => 0,
        ];

        // Initialize class data structure
        foreach ($getStudentAttendanceByGradeUserDTO->grade_level_class_ids as $classId) {
            $classAttendanceData[$classId] = [
                'grade_level_class_id' => $classId,
                'grade_level_class' => null,
                'students' => [],
                'class_summary' => [
                    'total_students' => 0,
                    'present_count' => 0,
                    'absent_count' => 0,
                    'partial_count' => 0,
                ],
            ];
        }

        // Process attendance records
        foreach ($attendanceRecords as $record) {
            $classId = $record->grade_level_class_id;
            $studentId = $record->student_id;

            // Set class information (from first record of that class)
            if (is_null($classAttendanceData[$classId]['grade_level_class']) && $record->grade_level_class) {
                $classAttendanceData[$classId]['grade_level_class'] = [
                    'id' => $record->grade_level_class->id,
                    'name' => $record->grade_level_class->name,
                    'grade_level_id' => $record->grade_level_class->grade_level_id,
                ];
            }

            // Initialize student data if not exists
            if (! isset($classAttendanceData[$classId]['students'][$studentId])) {
                $classAttendanceData[$classId]['students'][$studentId] = [
                    'student_id' => $studentId,
                    'student' => $record->student ? [
                        'full_name' => $record->student->full_name,
                        'full_name_with_title' => $record->student->full_name_with_title,
                        'admission_number' => $record->student->admission_number,
                    ] : null,
                    'attendance_summary' => [
                        'status' => 'unknown',
                        'in_time' => null,
                        'out_time' => null,
                    ],
                    'attendance_records' => [],
                ];
            }

            // Add the individual record
            $classAttendanceData[$classId]['students'][$studentId]['attendance_records'][] = [
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
                    $classAttendanceData[$classId]['students'][$studentId]['attendance_summary']['in_time'] = $record->time;
                    break;
                case 2: // Out
                    $classAttendanceData[$classId]['students'][$studentId]['attendance_summary']['out_time'] = $record->time;
                    break;
                case 3: // Leave/Absent
                    $classAttendanceData[$classId]['students'][$studentId]['attendance_summary']['status'] = 'absent';
                    $classAttendanceData[$classId]['students'][$studentId]['attendance_summary']['in_time'] = $record->time;
                    break;
                case 4: // Other Absent types
                    $classAttendanceData[$classId]['students'][$studentId]['attendance_summary']['status'] = 'absent';
                    break;
            }
        }

        // Determine final attendance status for each student and calculate class summaries
        foreach ($classAttendanceData as $classId => &$classData) {
            foreach ($classData['students'] as $studentId => &$studentData) {
                if ($studentData['attendance_summary']['status'] === 'absent') {
                    // Already marked as absent, keep it
                    $classData['class_summary']['absent_count']++;

                    continue;
                }

                $hasIn = ! is_null($studentData['attendance_summary']['in_time']);
                $hasOut = ! is_null($studentData['attendance_summary']['out_time']);

                if ($hasIn && $hasOut) {
                    $studentData['attendance_summary']['status'] = 'present';
                    $classData['class_summary']['present_count']++;
                } elseif ($hasIn || $hasOut) {
                    $studentData['attendance_summary']['status'] = 'partial';
                    $classData['class_summary']['partial_count']++;
                } else {
                    $studentData['attendance_summary']['status'] = 'unknown';
                }
            }

            // Convert students associative array to indexed array
            $classData['students'] = array_values($classData['students']);
            $classData['class_summary']['total_students'] = count($classData['students']);

            // Add to overall statistics
            $overallStats['total_students'] += $classData['class_summary']['total_students'];
            $overallStats['present_count'] += $classData['class_summary']['present_count'];
            $overallStats['absent_count'] += $classData['class_summary']['absent_count'];
            $overallStats['partial_count'] += $classData['class_summary']['partial_count'];
        }

        // Convert classes associative array to indexed array
        $classesArray = array_values($classAttendanceData);

        // Apply pagination across all students from all classes
        $allStudents = [];
        foreach ($classesArray as $classData) {
            foreach ($classData['students'] as $student) {
                $student['class_info'] = [
                    'grade_level_class_id' => $classData['grade_level_class_id'],
                    'grade_level_class' => $classData['grade_level_class'],
                ];
                $allStudents[] = $student;
            }
        }

        $totalStudents = count($allStudents);
        $page = $getStudentAttendanceByGradeUserDTO->page;
        $pageSize = $getStudentAttendanceByGradeUserDTO->page_size;
        $offset = ($page - 1) * $pageSize;
        $paginatedStudents = array_slice($allStudents, $offset, $pageSize);

        // Rebuild classes array with paginated data
        $paginatedClasses = [];
        foreach ($paginatedStudents as $student) {
            $classId = $student['class_info']['grade_level_class_id'];

            if (! isset($paginatedClasses[$classId])) {
                // Find original class data
                $originalClass = null;
                foreach ($classesArray as $classData) {
                    if ($classData['grade_level_class_id'] === $classId) {
                        $originalClass = $classData;
                        break;
                    }
                }

                $paginatedClasses[$classId] = [
                    'grade_level_class_id' => $classId,
                    'grade_level_class' => $originalClass['grade_level_class'],
                    'students' => [],
                    'class_summary' => $originalClass['class_summary'], // Keep full summary stats
                ];
            }

            // Remove class_info from student as it's now in the class structure
            unset($student['class_info']);
            $paginatedClasses[$classId]['students'][] = $student;
        }

        $response = [
            'date' => $getStudentAttendanceByGradeUserDTO->date,
            'classes' => array_values($paginatedClasses),
            'pagination' => [
                'current_page' => $page,
                'total_pages' => (int) ceil($totalStudents / $pageSize),
                'per_page' => $pageSize,
                'total' => $totalStudents,
                'has_more_pages' => $page * $pageSize < $totalStudents,
            ],
        ];

        // Add overall summary if requested
        if ($getStudentAttendanceByGradeUserDTO->include_summary) {
            $response['overall_summary'] = array_merge($overallStats, [
                'total_classes' => count($getStudentAttendanceByGradeUserDTO->grade_level_class_ids),
            ]);
        }

        return $response;
    }
}
