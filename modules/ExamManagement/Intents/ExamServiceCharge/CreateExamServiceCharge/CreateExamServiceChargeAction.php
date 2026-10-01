<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\CreateExamServiceCharge;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ItemRate;
use Modules\ExamManagement\Models\ExamServiceCharge;

class CreateExamServiceChargeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamServiceChargeUserDTO = CreateExamServiceChargeUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createExamServiceChargeSystemDTO = CreateExamServiceChargeSystemDTO::validate($system_data);
        // Final Data Validation
        $createExamServiceChargeDTO = CreateExamServiceChargeDTO::validate(array_merge($createExamServiceChargeUserDTO, $createExamServiceChargeSystemDTO));

        // Save In Database
        $examServiceCharge = ExamServiceCharge::create($createExamServiceChargeDTO);

        // Item Rate Save
        ItemRate::where('item_type', 'Exam Service Charge')->where('exam_service_charge_id', $examServiceCharge->id)->update(['is_active' => 0]);
        $ExamServiceChargeRateVersion = ItemRate::where('item_type', 'Exam Service Charge')->where('exam_service_charge_id', $examServiceCharge->id)->max('version') ?? 0;
        $ExamServiceChargeRateData['version'] = $ExamServiceChargeRateVersion + 1;
        $ExamServiceChargeRateData['rate'] = $createExamServiceChargeUserDTO['exam_service_charge_amount'];
        $ExamServiceChargeRateData['exam_service_charge_id'] = $examServiceCharge->id;
        $ExamServiceChargeRateData['item_type'] = 'Exam Service Charge';
        $ExamServiceChargeRateData['created_by'] = $actionData['created_by'];
        $ExamServiceChargeRateData['is_active'] = 1;
        ItemRate::create($ExamServiceChargeRateData);

        return $examServiceCharge;
    }
}
