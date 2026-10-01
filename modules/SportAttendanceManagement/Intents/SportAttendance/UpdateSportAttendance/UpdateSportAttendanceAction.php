<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\UpdateSportAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportAttendanceManagement\Models\SportAttendance;

class UpdateSportAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSportAttendanceUserDTO = UpdateSportAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateSportAttendanceSystemDTO = UpdateSportAttendanceSystemDTO::validate($system_data);

        // Final Data Validation
        $updateSportAttendanceDTO = UpdateSportAttendanceDTO::validate(array_merge($updateSportAttendanceUserDTO, $updateSportAttendanceSystemDTO));

        // Find and Update In Database
        $sportAttendance = SportAttendance::findOrFail($updateSportAttendanceDTO['id']);
        $sportAttendance->update($updateSportAttendanceDTO);

        return $sportAttendance;
    }
}
