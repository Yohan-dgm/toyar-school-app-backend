<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\UpdateExamServiceCharge;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamServiceCharge;

class UpdateExamServiceChargeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamServiceChargeUserDTO = UpdateExamServiceChargeUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateExamServiceChargeSystemDTO = UpdateExamServiceChargeSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamServiceChargeDTO = UpdateExamServiceChargeDTO::validate(array_merge($updateExamServiceChargeUserDTO, $updateExamServiceChargeSystemDTO));
        // Save In Database
        ExamServiceCharge::where('id', $updateExamServiceChargeUserDTO['id'])->update($updateExamServiceChargeDTO);

        $examServiceCharge = ExamServiceCharge::where('id', $updateExamServiceChargeUserDTO['id'])->first();

        return $examServiceCharge;
    }
}
