<?php

namespace Modules\AccountManagement\Intents\ReceivableDashboard\UpdateReceivableDashboard;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceivableDashboard;

class UpdateReceivableDashboardAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateReceivableDashboardUserDTO = UpdateReceivableDashboardUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateReceivableDashboardSystemDTO = UpdateReceivableDashboardSystemDTO::validate($system_data);
        // Final Data Validation

        $updateReceivableDashboardDTO = UpdateReceivableDashboardDTO::validate(array_merge($updateReceivableDashboardUserDTO, $updateReceivableDashboardSystemDTO));
        // Save In Database
        // ReceivableDashboard::where('id', $updateReceivableDashboardUserDTO['id'])->update($updateReceivableDashboardDTO);
        // $receivable_dashboard = ReceivableDashboard::find($updateReceivableDashboardUserDTO['id']);
        $receivable_dashboard = [];

        return $receivable_dashboard;
    }
}
