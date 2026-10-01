<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\UpdateAcademicTimetable;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\AcademicTimetable;

class UpdateAcademicTimetableAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateAcademicTimetableUserDTO = UpdateAcademicTimetableUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateAcademicTimetableSystemDTO = UpdateAcademicTimetableSystemDTO::validate($system_data);

        // Final Data Validation
        $updateAcademicTimetableDTO = UpdateAcademicTimetableDTO::validate(array_merge($updateAcademicTimetableUserDTO, $updateAcademicTimetableSystemDTO));

        // Find and Update Record
        $academicTimetable = AcademicTimetable::findOrFail($updateAcademicTimetableDTO['id']);
        $academicTimetable->update($updateAcademicTimetableDTO);

        return $academicTimetable;
    }
}
