<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\DeleteStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DeleteStudentAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public ?int $attendance_id,
        public ?int $student_id,
        public ?string $date,
        public ?int $grade_level_class_id,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user - date is required, attendance_id, student_id, and grade_level_class_id are optional
            'attendance_id' => ['nullable', new IntegerType],
            'student_id' => ['nullable', new IntegerType],
            'date' => [new Required, 'date_format:Y-m-d'],
            'grade_level_class_id' => ['nullable', new IntegerType],
            // system
        ];
    }
}
