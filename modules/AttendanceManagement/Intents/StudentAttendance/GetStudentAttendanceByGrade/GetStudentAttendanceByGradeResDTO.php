<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByGrade;

use Spatie\LaravelData\Data;

class GetStudentAttendanceByGradeResDTO extends Data
{
    public function __construct(
        public string $date,
        public array $classes,
        public array $pagination,
        public ?array $overall_summary = null
    ) {}

    /**
     * Validates and structures the response data
     */
    public static function fromArray(array $data): self
    {
        // Ensure proper structure for classes
        $classes = array_map(function ($classData) {
            return [
                'grade_level_class_id' => $classData['grade_level_class_id'] ?? null,
                'grade_level_class' => $classData['grade_level_class'] ?? null,
                'students' => array_map(function ($student) {
                    return [
                        'student_id' => $student['student_id'] ?? null,
                        'student' => $student['student'] ?? null,
                        'attendance_summary' => [
                            'status' => $student['attendance_summary']['status'] ?? 'unknown',
                            'in_time' => $student['attendance_summary']['in_time'] ?? null,
                            'out_time' => $student['attendance_summary']['out_time'] ?? null,
                        ],
                        'attendance_records' => $student['attendance_records'] ?? [],
                    ];
                }, $classData['students'] ?? []),
                'class_summary' => [
                    'total_students' => $classData['class_summary']['total_students'] ?? 0,
                    'present_count' => $classData['class_summary']['present_count'] ?? 0,
                    'absent_count' => $classData['class_summary']['absent_count'] ?? 0,
                    'partial_count' => $classData['class_summary']['partial_count'] ?? 0,
                ],
            ];
        }, $data['classes'] ?? []);

        // Ensure proper structure for pagination
        $pagination = [
            'current_page' => $data['pagination']['current_page'] ?? 1,
            'total_pages' => $data['pagination']['total_pages'] ?? 1,
            'per_page' => $data['pagination']['per_page'] ?? 100,
            'total' => $data['pagination']['total'] ?? 0,
            'has_more_pages' => $data['pagination']['has_more_pages'] ?? false,
        ];

        // Ensure proper structure for overall summary (if present)
        $overallSummary = null;
        if (isset($data['overall_summary'])) {
            $overallSummary = [
                'total_classes' => $data['overall_summary']['total_classes'] ?? 0,
                'total_students' => $data['overall_summary']['total_students'] ?? 0,
                'present_count' => $data['overall_summary']['present_count'] ?? 0,
                'absent_count' => $data['overall_summary']['absent_count'] ?? 0,
                'partial_count' => $data['overall_summary']['partial_count'] ?? 0,
            ];
        }

        return new self(
            date: $data['date'] ?? '',
            classes: $classes,
            pagination: $pagination,
            overall_summary: $overallSummary
        );
    }
}
