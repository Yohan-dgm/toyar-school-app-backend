<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\DeleteStudentAttendance;

use Spatie\LaravelData\Data;

class DeleteStudentAttendanceDTO extends Data
{
    public function __construct(
        // user
        public ?int $attendance_id,
        public ?int $student_id,
        public string $date,
        public ?int $grade_level_class_id,
        // system
        public int $deleted_by
    ) {}
}
