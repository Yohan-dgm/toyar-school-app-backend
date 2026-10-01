<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\UpdateStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentAttendanceDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public int $grade_level_class_id,
        public string $date,
        public string $attendance_status,
        public ?string $in_time,
        public ?string $out_time,
        public ?string $notes,
        public ?string $reason,
        // system
        public int $created_by,
        public int $updated_by
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required, new IntegerType],
            'grade_level_class_id' => [new Required, new IntegerType],
            'date' => [new Required, 'date_format:Y-m-d'],
            'attendance_status' => [new Required, new StringType, 'in:present,absent,late'],
            'in_time' => ['nullable', 'string'],
            'out_time' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'reason' => ['nullable', 'string'],
            // system
            'created_by' => [new Required, new IntegerType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
