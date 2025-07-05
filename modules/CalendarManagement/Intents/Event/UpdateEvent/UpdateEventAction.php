<?php

namespace Modules\CalendarManagement\Intents\Event\UpdateEvent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Event;
use Modules\OrganizationManagement\Models\SchoolDate;

class UpdateEventAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEventUserDTO = UpdateEventUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['approved_by'] = 0;

        if (
            $updateEventUserDTO['visibility_type'] === 'Approval Management' ||
            $updateEventUserDTO['visibility_type'] === 'Approval Principle'
        ) {
            $system_data['is_approved'] = false;
            $system_data['request_visibility_type'] = $updateEventUserDTO['visibility_type'];
        } else {
            $system_data['is_approved'] = true;
        }
        // System Data Validation
        $updateEventSystemDTO = UpdateEventSystemDTO::validate($system_data);
        // Final Data Validation

        $updateEventDTO = UpdateEventDTO::validate(array_merge($updateEventUserDTO, $updateEventSystemDTO));

        // Save In Database
        // Save In Database
        Event::where('id', $updateEventUserDTO['id'])->update($updateEventDTO);
        $event = Event::find($updateEventUserDTO['id']);

        return $event;
    }
}
