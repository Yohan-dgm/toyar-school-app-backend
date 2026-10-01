<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class BulkCreateStudentAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $grade_level_class_name,
        public string $date,
        public string $in_time,
        public string $out_time,
        public ?array $student_list,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'grade_level_class_name' => [],
            'date' => [new Required],
            'in_time' => [new Required],
            'out_time' => [new Required],
            'student_list' => [],
            // system
        ];
    }
}
