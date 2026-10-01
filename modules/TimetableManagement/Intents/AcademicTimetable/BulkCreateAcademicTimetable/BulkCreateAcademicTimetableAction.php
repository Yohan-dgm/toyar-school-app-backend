<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\BulkCreateAcademicTimetable;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\AcademicTimetable;

class BulkCreateAcademicTimetableAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $bulkCreateAcademicTimetableUserDTO = BulkCreateAcademicTimetableUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $bulkCreateAcademicTimetableSystemDTO = BulkCreateAcademicTimetableSystemDTO::validate($system_data);

        // Create records
        $createdRecords = [];

        DB::beginTransaction();
        try {
            foreach ($bulkCreateAcademicTimetableUserDTO['academic_timetables'] as $academicTimetableData) {
                // Add created_by to each record
                $academicTimetableData['created_by'] = $system_data['created_by'];

                // Set default values
                if (! isset($academicTimetableData['is_active'])) {
                    $academicTimetableData['is_active'] = true;
                }

                // Create the record
                $academicTimetable = AcademicTimetable::create($academicTimetableData);
                $createdRecords[] = $academicTimetable;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return $createdRecords;
    }
}
