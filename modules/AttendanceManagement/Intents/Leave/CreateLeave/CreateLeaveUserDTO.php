<?php

namespace Modules\AttendanceManagement\Intents\Leave\CreateLeave;

use DateTime;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Decimal;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateLeaveUserDTO extends Data
{
    public function __construct(

        // user
        public int $employee_id,
        public int $leave_type_id,
        public string $leave_duration_type,
        public ?DateTime $leave_date,
        public ?DateTime $leave_period_start_date,
        public ?DateTime $leave_period_end_date,
        public DateTime $next_reporting_date,
  
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "employee_id" => [new Required(), new IntegerType()],
            "leave_type_id" =>  [new Required(), new IntegerType()], 
            "leave_duration_type" =>  [new Required()], 
            "next_reporting_date" =>  [new Required()], 
            // system
        ];
    }
}
