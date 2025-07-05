<?php

namespace Modules\CalendarManagement\Intents\Event\ApprovalEvent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Event;
use Modules\OrganizationManagement\Models\SchoolDate;

class ApprovalEventAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $approvalEventUserDTO = ApprovalEventUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['approved_by'] = $actionData['updated_by'];
        $system_data['is_approved'] = true;
        // System Data Validation
        $approvalEventSystemDTO = ApprovalEventSystemDTO::validate($system_data);
        // Final Data Validation

        $approvalEventDTO = ApprovalEventDTO::validate(array_merge($approvalEventUserDTO, $approvalEventSystemDTO));

        // Save In Database
        // Save In Database
        Event::where('id', $approvalEventUserDTO['id'])->update($approvalEventDTO);
        $event = Event::find($approvalEventUserDTO['id']);

        return $event;
    }
}
