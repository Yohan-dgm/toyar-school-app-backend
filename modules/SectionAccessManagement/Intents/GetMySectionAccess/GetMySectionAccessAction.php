<?php

namespace Modules\SectionAccessManagement\Intents\GetMySectionAccess;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SectionAccessManagement\Models\SectionAccess;

class GetMySectionAccessAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $sectionKeys = SectionAccess::where('user_id', $actionData['user_id'])
            ->pluck('section_key');

        return [
            'section_keys' => $sectionKeys,
        ];
    }
}
