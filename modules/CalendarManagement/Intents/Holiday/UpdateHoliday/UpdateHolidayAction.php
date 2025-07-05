<?php

namespace Modules\CalendarManagement\Intents\Holiday\UpdateHoliday;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Holiday;

class UpdateHolidayAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateHolidayUserDTO = UpdateHolidayUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateHolidaySystemDTO = UpdateHolidaySystemDTO::validate($system_data);
        // Final Data Validation

        $updateHolidayDTO = UpdateHolidayDTO::validate(array_merge($updateHolidayUserDTO, $updateHolidaySystemDTO));

        // Save In Database
        // Save In Database
        Holiday::where('id', $updateHolidayUserDTO['id'])->update($updateHolidayDTO);
        $holiday = Holiday::find($updateHolidayUserDTO['id']);

        return $holiday;
    }
}
