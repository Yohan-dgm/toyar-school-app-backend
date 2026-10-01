<?php

namespace Modules\SectionAccessManagement\Intents\RevokeSectionAccess;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SectionAccessManagement\Models\SectionAccess;

class RevokeSectionAccessAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $revokeSectionAccessUserDTO = RevokeSectionAccessUserDTO::validate($payloadArray);

        $deletedCount = SectionAccess::where('section_key', $revokeSectionAccessUserDTO['section_key'])
            ->where('user_id', $revokeSectionAccessUserDTO['user_id'])
            ->delete();

        return [
            'deleted' => $deletedCount > 0,
        ];
    }
}
