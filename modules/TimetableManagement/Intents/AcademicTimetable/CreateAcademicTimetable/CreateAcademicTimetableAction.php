<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\CreateAcademicTimetable;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\AcademicTimetable;

class CreateAcademicTimetableAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createAcademicTimetableUserDTO = CreateAcademicTimetableUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createAcademicTimetableSystemDTO = CreateAcademicTimetableSystemDTO::validate($system_data);

        // Final Data Validation
        $createAcademicTimetableDTO = CreateAcademicTimetableDTO::validate(array_merge($createAcademicTimetableUserDTO, $createAcademicTimetableSystemDTO));

        // Set default values
        if (! isset($createAcademicTimetableDTO['is_active'])) {
            $createAcademicTimetableDTO['is_active'] = true;
        }

        // Save In Database
        $academicTimetable = AcademicTimetable::create($createAcademicTimetableDTO);

        return $academicTimetable;
    }
}
