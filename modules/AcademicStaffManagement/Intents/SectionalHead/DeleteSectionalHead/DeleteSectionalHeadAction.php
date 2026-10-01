<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\DeleteSectionalHead;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AcademicStaffManagement\Models\SectionalHead;

class DeleteSectionalHeadAction
{
    use AsAction;

    public function handle($id)
    {
        // Find the sectional head assignment
        $sectionalHead = SectionalHead::findOrFail($id);

        // Delete the assignment
        $sectionalHead->delete();

        return true;
    }
}
