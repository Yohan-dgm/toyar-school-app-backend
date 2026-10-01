<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\CreateSportTimetable;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\SportTimetable;

class CreateSportTimetableAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSportTimetableUserDTO = CreateSportTimetableUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createSportTimetableSystemDTO = CreateSportTimetableSystemDTO::validate($system_data);

        // Final Data Validation
        $createSportTimetableDTO = CreateSportTimetableDTO::validate(array_merge($createSportTimetableUserDTO, $createSportTimetableSystemDTO));

        // Set default values
        if (! isset($createSportTimetableDTO['is_active'])) {
            $createSportTimetableDTO['is_active'] = true;
        }

        // Save In Database
        $sportTimetable = SportTimetable::create($createSportTimetableDTO);

        return $sportTimetable;
    }
}
