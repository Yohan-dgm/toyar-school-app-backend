<?php

namespace Modules\LogManagement\Intents\ExamLog\CreateExamLog;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\LogManagement\Models\ExamLog;

class CreateExamLogAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamLogUserDTO = CreateExamLogUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createExamLogSystemDTO = CreateExamLogSystemDTO::validate($system_data);

        // Final Data Validation
        $createExamLogDTO = CreateExamLogDTO::validate(array_merge($createExamLogUserDTO, $createExamLogSystemDTO));

        // Save In Database
        $CreateExamLog = ExamLog::create($createExamLogDTO);

        return $CreateExamLog;
    }
}
