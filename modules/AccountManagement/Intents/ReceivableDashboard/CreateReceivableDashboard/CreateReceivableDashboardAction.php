<?php

namespace Modules\AccountManagement\Intents\ReceivableDashboard\CreateReceivableDashboard;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceivableDashboard;

class CreateReceivableDashboardAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createReceivableDashboardUserDTO = CreateReceivableDashboardUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createReceivableDashboardSystemDTO = CreateReceivableDashboardSystemDTO::validate($system_data);
        // Final Data Validation
        $createReceivableDashboardDTO = CreateReceivableDashboardDTO::validate(array_merge($createReceivableDashboardUserDTO, $createReceivableDashboardSystemDTO));

        // Save In Database
        // $receivableDashboard = ReceivableDashboard::create($createReceivableDashboardDTO);
        $receivableDashboard = [];

        return $receivableDashboard;
    }
}
