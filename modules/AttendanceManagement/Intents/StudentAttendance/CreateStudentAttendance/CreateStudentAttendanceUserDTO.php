<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public ?string $date,
        public ?string $time,
        public int $attendance_type_id,
        public ?string $in_time,
        public ?string $out_time,
        public ?array $student_list,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required, new IntegerType],
            'attendance_type_id' => [new Required, new IntegerType],
            'in_time' => [],
            'out_time' => [],
            'student_list' => [],
            // system
        ];
    }
}
