<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceAggregatedListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetEducatorAttendanceAggregatedListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $educator_attendance_count,
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
