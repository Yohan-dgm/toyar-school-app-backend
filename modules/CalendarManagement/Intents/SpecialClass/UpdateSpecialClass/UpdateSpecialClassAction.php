<?php

namespace Modules\CalendarManagement\Intents\SpecialClass\UpdateSpecialClass;

use Modules\CalendarManagement\Models\SpecialClass;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateSpecialClassAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSpecialClassUserDTO = UpdateSpecialClassUserDTO::validate($payloadArray);

        // Data Prep   
        $system_data = [];

        // System Data Prep 
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateSpecialClassSystemDTO = UpdateSpecialClassSystemDTO::validate($system_data);

        // Final Data Validation
        $updateSpecialClassDTO = UpdateSpecialClassDTO::validate(array_merge($updateSpecialClassUserDTO, $updateSpecialClassSystemDTO));

        // Save In Database
        SpecialClass::where('id', $updateSpecialClassUserDTO['id'])->update($updateSpecialClassDTO);
        $specialClass = SpecialClass::find($updateSpecialClassUserDTO['id']);

        return $specialClass;
    }
}
