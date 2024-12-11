<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class EditStudentAttendanceDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public string $date,
        public ?string $in_time,
        public ?string $out_time,
        public string $attendance_type, // Present, Absent
        // system
        public int $updated_by
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "student_id" => [new Required(), new IntegerType()],
            "date" => [new Required()],
            "attendance_type" =>  [new Required(), new StringType()],
            // system
            "updated_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
