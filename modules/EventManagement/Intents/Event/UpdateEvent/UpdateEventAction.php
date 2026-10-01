<?php

namespace Modules\EventManagement\Intents\Event\UpdateEvent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EventManagement\Models\Event;
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

        // System Data Validation
        $updateEventSystemDTO = UpdateEventSystemDTO::validate($system_data);
        // Final Data Validation

        $updateEventDTO = UpdateEventDTO::validate(array_merge($updateEventUserDTO, $updateEventSystemDTO));

        // Save In Database
        $school_date = SchoolDate::where(function (Builder $school_date_query) use ($updateEventDTO) {
            $school_date_query->where('date', '=', ''.$updateEventDTO['date'].'');
        })->first();

        $updateEventDTO['school_date_id'] = $school_date->id;

        unset($updateEventDTO['date']);
        if ($updateEventDTO['duration_type'] == 'All Day') {
            unset($updateEventDTO['start_time']);
            unset($updateEventDTO['end_time']);
            $updateEventDTO['start_time'] = null;
            $updateEventDTO['end_time'] = null;
        }

        // Save In Database
        Event::where('id', $updateEventUserDTO['id'])->update($updateEventDTO);
        $event = Event::find($updateEventUserDTO['id']);

        return $event;
    }
}
