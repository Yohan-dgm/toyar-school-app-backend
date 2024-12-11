<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class BulkCreateStudentAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public int $grade_level_class_id,
        public string $date,
        // public string $time,
        // public int $attendance_type_id,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "grade_level_class_id" => [new Required(), new IntegerType()],
            // "attendance_type_id" =>  [new Required(), new IntegerType()],
            "date" =>  [new Required()],
            // "time" =>  [new Required()],
            // system
        ];
    }
}
