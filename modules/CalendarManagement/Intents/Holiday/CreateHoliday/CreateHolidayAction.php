<?php

namespace Modules\CalendarManagement\Intents\Holiday\CreateHoliday;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Holiday;
use Modules\OrganizationManagement\Models\SchoolDate;

class CreateHolidayAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createHolidayUserDTO = CreateHolidayUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createHolidaySystemDTO = CreateHolidaySystemDTO::validate($system_data);
        // Final Data Validation
        $createHolidayDTO = CreateHolidayDTO::validate(array_merge($createHolidayUserDTO, $createHolidaySystemDTO));

        // Save In Database
        $holiday = Holiday::create($createHolidayDTO);

        return $holiday;
    }
}
