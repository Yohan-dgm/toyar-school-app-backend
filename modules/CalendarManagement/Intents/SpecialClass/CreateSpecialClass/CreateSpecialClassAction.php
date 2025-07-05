<?php

namespace Modules\CalendarManagement\Intents\SpecialClass\CreateSpecialClass;

use Modules\CalendarManagement\Models\SpecialClass;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateSpecialClassAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSpecialClassUserDTO = CreateSpecialClassUserDTO::validate($payloadArray);

        // Data Prep   
        $system_data = [];

        // System Data Prep 
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createSpecialClassSystemDTO = CreateSpecialClassSystemDTO::validate($system_data);

        // Final Data Validation
        $createSpecialClassDTO = CreateSpecialClassDTO::validate(array_merge($createSpecialClassUserDTO, $createSpecialClassSystemDTO));

        // Save In Database
        $createSpecialClass = SpecialClass::create($createSpecialClassDTO);

        return $createSpecialClass;
    }
}
