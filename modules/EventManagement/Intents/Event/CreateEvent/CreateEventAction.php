<?php

namespace Modules\EventManagement\Intents\Event\CreateEvent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EventManagement\Models\Event;
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

        // System Data Validation
        $createEventSystemDTO = CreateEventSystemDTO::validate($system_data);
        // Final Data Validation
        $createEventDTO = CreateEventDTO::validate(array_merge($createEventUserDTO, $createEventSystemDTO));

        // Save In Database
        $school_date = SchoolDate::where(function (Builder $school_date_query) use ($createEventDTO) {
            $school_date_query->where('date', '=', ''.$createEventDTO['date'].'');
        })->first();

        $createEventDTO['school_date_id'] = $school_date->id;
        unset($createEventDTO['date']);
        if ($createEventDTO['duration_type'] == 'All Day') {
            unset($createEventDTO['start_time']);
            unset($createEventDTO['end_time']);
        }

        $event = Event::create($createEventDTO);

        return $event;
    }
}
