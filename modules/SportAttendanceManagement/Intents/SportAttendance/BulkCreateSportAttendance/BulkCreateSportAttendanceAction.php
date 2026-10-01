<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\BulkCreateSportAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportAttendanceManagement\Models\SportAttendance;

class BulkCreateSportAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $bulkCreateSportAttendanceUserDTO = BulkCreateSportAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $bulkCreateSportAttendanceSystemDTO = BulkCreateSportAttendanceSystemDTO::validate($system_data);

        // Prepare data for bulk insert
        $sportAttendances = [];
        foreach ($bulkCreateSportAttendanceUserDTO['sport_attendances'] as $attendance) {
            $sportAttendances[] = array_merge($attendance, ['created_by' => $actionData['created_by']]);
        }

        // Save In Database
        $createdAttendances = SportAttendance::insert($sportAttendances);

        return [
            'created_count' => count($sportAttendances),
            'success' => $createdAttendances,
        ];
    }
}
