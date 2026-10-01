<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendanceByStudentId;

use Spatie\LaravelData\Data;

class GetTodayStudentAttendanceByStudentIdResDTO extends Data
{
    public function __construct(
        public int $student_id,
        public array $student,
        public string $date,
        public ?string $attendance_status,
        public ?int $attendance_type_id,
        public ?string $time,
        public ?string $notes,
        public ?array $attendance_type,
        public ?array $attendance_reason,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            student_id: $data['student_id'],
            student: $data['student'] ?? [],
            date: $data['date'],
            attendance_status: $data['attendance_status'] ?? null,
            attendance_type_id: $data['attendance_type_id'] ?? null,
            time: $data['time'] ?? null,
            notes: $data['notes'] ?? null,
            attendance_type: $data['attendance_type'] ?? null,
            attendance_reason: $data['attendance_reason'] ?? null,
        );
    }
}
