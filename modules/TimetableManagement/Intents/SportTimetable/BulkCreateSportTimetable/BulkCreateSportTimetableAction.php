<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\BulkCreateSportTimetable;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\SportTimetable;

class BulkCreateSportTimetableAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $bulkCreateSportTimetableUserDTO = BulkCreateSportTimetableUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $bulkCreateSportTimetableSystemDTO = BulkCreateSportTimetableSystemDTO::validate($system_data);

        // Create records
        $createdRecords = [];

        DB::beginTransaction();
        try {
            foreach ($bulkCreateSportTimetableUserDTO['sport_timetables'] as $sportTimetableData) {
                // Add created_by to each record
                $sportTimetableData['created_by'] = $system_data['created_by'];

                // Set default values
                if (! isset($sportTimetableData['is_active'])) {
                    $sportTimetableData['is_active'] = true;
                }

                // Create the record
                $sportTimetable = SportTimetable::create($sportTimetableData);
                $createdRecords[] = $sportTimetable;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return $createdRecords;
    }
}
