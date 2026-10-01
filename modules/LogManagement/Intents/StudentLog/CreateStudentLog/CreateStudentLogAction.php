<?php

namespace Modules\LogManagement\Intents\StudentLog\CreateStudentLog;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\LogManagement\Models\StudentLog;

class CreateStudentLogAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentLogUserDTO = CreateStudentLogUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createStudentLogSystemDTO = CreateStudentLogSystemDTO::validate($system_data);

        // Final Data Validation
        $createStudentLogDTO = CreateStudentLogDTO::validate(array_merge($createStudentLogUserDTO, $createStudentLogSystemDTO));

        // Save In Database
        $CreateStudentLog = StudentLog::create($createStudentLogDTO);

        return $CreateStudentLog;
    }
}
