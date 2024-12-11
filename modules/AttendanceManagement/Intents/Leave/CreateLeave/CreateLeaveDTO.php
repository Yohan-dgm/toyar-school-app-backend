<?php

namespace Modules\AttendanceManagement\Intents\Leave\CreateLeave;

use DateTime;
use Illuminate\Http\Request; 
use Ramsey\Uuid\Type\Decimal;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateLeaveDTO extends Data
{
    public function __construct(
        // user
        public int $employee_id,
        public int $leave_type_id,
        public string $leave_duration_type,
        public ?string $leave_date, // yyyy-MM-dd
        public ?string $leave_period_start_date, // yyyy-MM-dd
        public ?string $leave_period_end_date, // yyyy-MM-dd
        public string $next_reporting_date, // yyyy-MM-dd
        
        // system
        public int $created_by, 
        public Decimal $leave_period_working_days_count,
        public int $leave_status_type_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            "employee_id" => [new Required(), new IntegerType()],
            "leave_duration_type" =>  [new Required()], 
            "next_reporting_date" =>  [new Required()],  
            "leave_date" =>  [new RequiredIf('leave_duration_type', ['Full-Day','Half-Day'])],
            "leave_period_start_date" =>  [new RequiredIf('leave_duration_type', 'Period')],
            "leave_period_end_date" =>  [new RequiredIf('leave_duration_type', 'Period')],
            "leave_type_id" =>  [new Required(), new IntegerType()], 
            // system
            "created_by" =>  [new Required(), new IntegerType()], 
            "leave_status_type_id" =>  [new Required(), new IntegerType()],
        ];
    }
}
