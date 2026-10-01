<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\CreateSportAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportAttendanceManagement\Models\SportAttendance;

class CreateSportAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSportAttendanceUserDTO = CreateSportAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createSportAttendanceSystemDTO = CreateSportAttendanceSystemDTO::validate($system_data);

        // Final Data Validation
        $createSportAttendanceDTO = CreateSportAttendanceDTO::validate(array_merge($createSportAttendanceUserDTO, $createSportAttendanceSystemDTO));

        // Save In Database
        $sportAttendance = SportAttendance::create($createSportAttendanceDTO);

        return $sportAttendance;
    }
}
