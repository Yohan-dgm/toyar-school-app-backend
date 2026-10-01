<?php

namespace Modules\SectionAccessManagement\Intents\GetSectionAccessListData;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SectionAccessManagement\Models\SectionAccess;

class GetSectionAccessListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getSectionAccessListDataUserDTO = GetSectionAccessListDataUserDTO::validate($payloadArray);

        return SectionAccess::where('section_key', $getSectionAccessListDataUserDTO['section_key'])
            ->with('user:id,full_name,username')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
