<?php

namespace Modules\CalendarManagement\Intents\EventCategory\CreateEventCategory;

use Modules\CalendarManagement\Models\EventCategory;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateEventCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEventCategoryUserDTO = CreateEventCategoryUserDTO::validate($payloadArray);

        // Data Prep   
        $system_data = [];

        // System Data Prep 
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createEventCategorySystemDTO = CreateEventCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createEventCategoryDTO = CreateEventCategoryDTO::validate(array_merge($createEventCategoryUserDTO, $createEventCategorySystemDTO));

        // Save In Database
        $eventCategory = EventCategory::create($createEventCategoryDTO);

        return $eventCategory;
    }
}
