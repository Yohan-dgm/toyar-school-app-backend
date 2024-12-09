<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class EditStudentAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public ?string $date,
        public ?string $time,
        public int $attendance_type_id,
        public int $student_attendance_id,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "student_id" => [new Required(), new IntegerType()],
            "attendance_type_id" =>  [new Required(), new IntegerType()],
            "student_attendance_id" =>  [new Required(), new IntegerType()],
            // system
        ];
    }
}
