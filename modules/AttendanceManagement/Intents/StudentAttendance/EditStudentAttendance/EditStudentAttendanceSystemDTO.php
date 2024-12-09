<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class EditStudentAttendanceSystemDTO extends Data
{
    public function __construct(
        public int $updated_by
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            "updated_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
