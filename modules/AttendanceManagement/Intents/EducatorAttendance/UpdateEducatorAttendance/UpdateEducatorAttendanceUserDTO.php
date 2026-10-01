<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\UpdateEducatorAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEducatorAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public int $educator_id,
        public string $date,
        public ?string $in_time,
        public ?string $out_time,
        public string $attendance_type, // Present, Absent
        public ?string $notes
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'educator_id' => [new Required, new IntegerType],
            'date' => [new Required],
            'attendance_type' => [new Required, new StringType],
            // system
        ];
    }
}
