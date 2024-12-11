<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\BulkCreateEducatorAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class BulkCreateEducatorAttendanceDTO extends Data
{
    public function __construct(
        // user
        public string $date,
        public string $in_time,
        public string $out_time,

        // system
        public int $created_by
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "date" =>  [new Required()],
            "in_time" =>  [new Required()],
            "out_time" =>  [new Required()],
            // system
            "created_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
