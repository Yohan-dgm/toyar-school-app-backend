<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\BulkCreateEducatorAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class BulkCreateEducatorAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public string $date,
        public string $in_time,
        public string $out_time,
        // public int $attendance_type_id,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "date" =>  [new Required()],
            "in_time" =>  [new Required()],
            "out_time" =>  [new Required()],
            // system
        ];
    }
}
