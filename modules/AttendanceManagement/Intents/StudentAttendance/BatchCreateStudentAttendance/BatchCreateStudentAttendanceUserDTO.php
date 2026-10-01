<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BatchCreateStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class BatchCreateStudentAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public array $attendance_data,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'attendance_data' => [new Required, 'array', 'min:1'],
            'attendance_data.*.student_id' => [new Required, new IntegerType],
            'attendance_data.*.grade_level_class_id' => [new Required, new IntegerType],
            'attendance_data.*.date' => [new Required, 'date_format:Y-m-d'],
            'attendance_data.*.attendance_type_id' => [new Required, new IntegerType],
            'attendance_data.*.in_time' => ['nullable', 'string', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/'],
            'attendance_data.*.out_time' => ['nullable', 'string', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/'],
            'attendance_data.*.reason' => ['nullable', 'string', 'max:500'],
            // system
        ];
    }
}
