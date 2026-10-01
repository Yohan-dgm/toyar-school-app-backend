<?php

namespace Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\LogManagement\Models\InvoicesLog;

class CreateInvoicesLogAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createInvoicesLogUserDTO = CreateInvoicesLogUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createInvoicesLogSystemDTO = CreateInvoicesLogSystemDTO::validate($system_data);

        // Final Data Validation
        $createInvoicesLogDTO = CreateInvoicesLogDTO::validate(array_merge($createInvoicesLogUserDTO, $createInvoicesLogSystemDTO));

        // Save In Database
        $CreateInvoicesLog = InvoicesLog::create($createInvoicesLogDTO);

        return $CreateInvoicesLog;
    }
}
