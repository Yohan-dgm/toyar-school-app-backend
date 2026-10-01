<?php

namespace Modules\AccountManagement\Intents\StudentBillsData\GetStudentBillsData;

use Spatie\LaravelData\Data;

class GetStudentBillsDataResDTO extends Data
{
    public function __construct(
        public array $student_bills_data,
    ) {}
}
