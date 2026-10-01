<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetEducatorAttendanceListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $educator_attendance_count,
        public ?object $present_educator_count,
        public ?object $absent_educator_count,
        public ?object $on_leave_educator_count,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
