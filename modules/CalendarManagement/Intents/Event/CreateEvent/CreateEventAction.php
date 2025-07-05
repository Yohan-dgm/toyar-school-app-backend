<?php

namespace Modules\CalendarManagement\Intents\Event\CreateEvent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Event;
use Modules\OrganizationManagement\Models\SchoolDate;

class CreateEventAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEventUserDTO = CreateEventUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['approved_by'] = 0;

        if (
            $createEventUserDTO['visibility_type'] === 'Approval Management' ||
            $createEventUserDTO['visibility_type'] === 'Approval Principle'
        ) {
            $system_data['is_approved'] = false;
            $system_data['request_visibility_type'] = $createEventUserDTO['visibility_type'];
        } else {
            $system_data['is_approved'] = true;
        }
        // System Data Validation
        $createEventSystemDTO = CreateEventSystemDTO::validate($system_data);
        // Final Data Validation
        $createEventDTO = CreateEventDTO::validate(array_merge($createEventUserDTO, $createEventSystemDTO));

        // Save In Database
        $event = Event::create($createEventDTO);

        return $event;
    }
}
