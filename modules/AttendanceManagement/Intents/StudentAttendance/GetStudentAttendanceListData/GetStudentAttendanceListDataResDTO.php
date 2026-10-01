<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentAttendanceListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $student_attendance_count,
        public ?object $present_student_count,
        public ?object $absent_student_count,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
