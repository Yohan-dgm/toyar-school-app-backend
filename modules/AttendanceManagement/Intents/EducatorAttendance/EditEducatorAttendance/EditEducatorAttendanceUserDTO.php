<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\EditEducatorAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class EditEducatorAttendanceUserDTO extends Data
{
    public function __construct(
        // user
        public int $educator_id,
        public ?string $date,
        public ?array $in_out_list,
        public int $attendance_type, // Present, Absent, Leave
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "educator_id" => [new Required(), new IntegerType()],
            "attendance_type" =>  [new Required(), new StringType()],
            // system
        ];
    }
}
