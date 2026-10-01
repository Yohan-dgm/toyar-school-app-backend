<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\UpdateStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentAttendanceSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public int $updated_by
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'created_by' => [new Required, new IntegerType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
