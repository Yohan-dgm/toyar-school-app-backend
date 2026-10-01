<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BatchCreateStudentAttendance;

use Spatie\LaravelData\Data;

class BatchCreateStudentAttendanceDTO extends Data
{
    public function __construct(
        // user
        public array $attendance_data,
        // system
        public int $created_by
    ) {}
}
