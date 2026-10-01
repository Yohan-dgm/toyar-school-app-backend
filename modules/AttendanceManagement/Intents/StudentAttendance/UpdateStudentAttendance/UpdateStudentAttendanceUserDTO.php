<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\UpdateStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public int $grade_level_class_id,
        public string $date,
        public string $attendance_status, // 'present', 'absent', 'late'
        public ?string $in_time,
        public ?string $out_time,
        public ?string $notes,
        public ?string $reason
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required, new IntegerType],
            'grade_level_class_id' => [new Required, new IntegerType],
            'date' => [new Required, 'date_format:Y-m-d'],
            'attendance_status' => [new Required, 'string', 'in:present,absent,late'],
            'in_time' => ['nullable', 'string', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
            'out_time' => ['nullable', 'string', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'reason' => ['nullable', 'string', 'max:500'],
            // system
        ];
    }
}
