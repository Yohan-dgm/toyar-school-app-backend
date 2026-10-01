<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceAggregatedListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentAttendanceAggregatedListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $student_attendance_count,
        public ?object $grade_level_class_list,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
