<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\UpdateSportTimetable;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\SportTimetable;

class UpdateSportTimetableAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSportTimetableUserDTO = UpdateSportTimetableUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateSportTimetableSystemDTO = UpdateSportTimetableSystemDTO::validate($system_data);

        // Final Data Validation
        $updateSportTimetableDTO = UpdateSportTimetableDTO::validate(array_merge($updateSportTimetableUserDTO, $updateSportTimetableSystemDTO));

        // Find and Update Record
        $sportTimetable = SportTimetable::findOrFail($updateSportTimetableDTO['id']);
        $sportTimetable->update($updateSportTimetableDTO);

        return $sportTimetable;
    }
}
