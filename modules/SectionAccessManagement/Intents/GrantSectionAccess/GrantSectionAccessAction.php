<?php

namespace Modules\SectionAccessManagement\Intents\GrantSectionAccess;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SectionAccessManagement\Models\SectionAccess;

class GrantSectionAccessAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $grantSectionAccessUserDTO = GrantSectionAccessUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['granted_by'] = $actionData['granted_by'];

        // System Data Validation
        $grantSectionAccessSystemDTO = GrantSectionAccessSystemDTO::validate($system_data);

        $sectionAccess = SectionAccess::updateOrCreate(
            [
                'section_key' => $grantSectionAccessUserDTO['section_key'],
                'user_id' => $grantSectionAccessUserDTO['user_id'],
            ],
            [
                'granted_by' => $grantSectionAccessSystemDTO['granted_by'],
            ]
        );

        return $sectionAccess;
    }
}
