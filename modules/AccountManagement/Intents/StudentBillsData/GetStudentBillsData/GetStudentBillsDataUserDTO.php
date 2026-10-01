<?php

namespace Modules\AccountManagement\Intents\StudentBillsData\GetStudentBillsData;

use Spatie\LaravelData\Data;

class GetStudentBillsDataUserDTO extends Data
{
    public function __construct(
        public array $student_ids,
    ) {}
}
