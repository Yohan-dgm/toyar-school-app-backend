<?php

namespace Modules\CalendarManagement\Intents\EventCategory\UpdateEventCategory;

use Modules\CalendarManagement\Models\EventCategory;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateEventCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEventCategoryUserDTO = UpdateEventCategoryUserDTO::validate($payloadArray);

        // Data Prep   
        $system_data = [];

        // System Data Prep 
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateEventCategorySystemDTO = UpdateEventCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $updateEventCategoryDTO = UpdateEventCategoryDTO::validate(array_merge($updateEventCategoryUserDTO, $updateEventCategorySystemDTO));

        // Save In Database
        EventCategory::where('id', $updateEventCategoryUserDTO['id'])->update($updateEventCategoryDTO);
        $eventCategory = EventCategory::find($updateEventCategoryUserDTO['id']);

        return $eventCategory;
    }
}
