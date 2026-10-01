<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByDateAndClass;

use Spatie\LaravelData\Data;

class GetStudentAttendanceByDateAndClassResDTO extends Data
{
    public function __construct(
        public array $attendance_records,
        public array $summary,
        public array $pagination
    ) {}

    /**
     * Validates the structure of attendance records
     */
    public static function fromArray(array $data): self
    {
        // Ensure proper structure for attendance_records
        $attendanceRecords = array_map(function ($record) {
            return [
                'student_id' => $record['student_id'] ?? null,
                'student' => $record['student'] ?? null,
                'date' => $record['date'] ?? null,
                'attendance_summary' => [
                    'status' => $record['attendance_summary']['status'] ?? 'unknown',
                    'in_time' => $record['attendance_summary']['in_time'] ?? null,
                    'out_time' => $record['attendance_summary']['out_time'] ?? null,
                ],
                'attendance_records' => $record['attendance_records'] ?? [],
            ];
        }, $data['attendance_records'] ?? []);

        // Ensure proper structure for summary
        $summary = [
            'total_students' => $data['summary']['total_students'] ?? 0,
            'present_count' => $data['summary']['present_count'] ?? 0,
            'absent_count' => $data['summary']['absent_count'] ?? 0,
            'partial_count' => $data['summary']['partial_count'] ?? 0,
            'date' => $data['summary']['date'] ?? null,
            'grade_level_class_id' => $data['summary']['grade_level_class_id'] ?? null,
        ];

        // Ensure proper structure for pagination
        $pagination = [
            'current_page' => $data['pagination']['current_page'] ?? 1,
            'total_pages' => $data['pagination']['total_pages'] ?? 1,
            'per_page' => $data['pagination']['per_page'] ?? 50,
            'total' => $data['pagination']['total'] ?? 0,
            'has_more_pages' => $data['pagination']['has_more_pages'] ?? false,
        ];

        return new self(
            attendance_records: $attendanceRecords,
            summary: $summary,
            pagination: $pagination
        );
    }
}
