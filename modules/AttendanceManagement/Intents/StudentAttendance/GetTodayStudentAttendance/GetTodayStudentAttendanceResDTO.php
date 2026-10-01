<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendance;

use Spatie\LaravelData\Data;

class GetTodayStudentAttendanceResDTO extends Data
{
    public function __construct(
        public array $attendance_records,
        public array $summary,
        public array $pagination
    ) {}

    public static function fromArray(array $data): self
    {
        $attendanceRecords = array_map(function ($record) {
            return [
                'student_id' => $record['student_id'] ?? null,
                'student' => $record['student'] ?? null,
                'date' => $record['date'] ?? null,
                'attendance_status' => $record['attendance_status'] ?? 'absent',
                'attendance_type_id' => $record['attendance_type_id'] ?? null,
                'time' => $record['time'] ?? null,
                'notes' => $record['notes'] ?? null,
                'attendance_type' => $record['attendance_type'] ?? null,
                'attendance_reason' => $record['attendance_reason'] ?? null,
            ];
        }, $data['attendance_records'] ?? []);

        $summary = [
            'total_students' => $data['summary']['total_students'] ?? 0,
            'present_count' => $data['summary']['present_count'] ?? 0,
            'absent_count' => $data['summary']['absent_count'] ?? 0,
            'late_count' => $data['summary']['late_count'] ?? 0,
            'date' => $data['summary']['date'] ?? null,
            'grade_level_class_id' => $data['summary']['grade_level_class_id'] ?? null,
        ];

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
