<?php

namespace Modules\AttendanceManagement\Intents\Leave\CreateLeave;

use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Decimal;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateLeaveSystemDTO extends Data
{
    public function __construct(
        public int $created_by, 
        public Decimal $leave_period_working_days_count,
        public int $leave_status_type_id,


    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            "created_by" =>  [new Required(), new IntegerType()], 
            "leave_status_type_id" =>  [new Required(), new IntegerType()],
            

        ];
    }
}
