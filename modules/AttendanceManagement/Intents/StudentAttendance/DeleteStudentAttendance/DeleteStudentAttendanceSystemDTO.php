<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\DeleteStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DeleteStudentAttendanceSystemDTO extends Data
{
    public function __construct(
        public int $deleted_by
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'deleted_by' => [new Required, new IntegerType],
        ];
    }
}
