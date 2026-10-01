<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BatchUpdateStudentAttendance;

use Spatie\LaravelData\Data;

class BatchUpdateStudentAttendanceDTO extends Data
{
    public function __construct(
        // user
        public string $date,
        public int $grade_level_class_id,
        public array $attendance_data,
        // system
        public int $created_by
    ) {}
}
