<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\UpdateSectionalHead;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AcademicStaffManagement\Models\SectionalHead;

class UpdateSectionalHeadAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSectionalHeadUserDTO = UpdateSectionalHeadUserDTO::validate($payloadArray);

        // Find the sectional head assignment
        $sectionalHead = SectionalHead::findOrFail($updateSectionalHeadUserDTO['id']);

        // Prepare data for update (only update provided fields)
        $data = ['updated_by' => $actionData['updated_by']];

        if (isset($updateSectionalHeadUserDTO['user_id'])) {
            $data['user_id'] = $updateSectionalHeadUserDTO['user_id'];
        }
        if (isset($updateSectionalHeadUserDTO['grade_level_id'])) {
            $data['grade_level_id'] = $updateSectionalHeadUserDTO['grade_level_id'];
        }
        if (isset($updateSectionalHeadUserDTO['academic_year'])) {
            $data['academic_year'] = $updateSectionalHeadUserDTO['academic_year'];
        }
        if (isset($updateSectionalHeadUserDTO['start_date'])) {
            $data['start_date'] = $updateSectionalHeadUserDTO['start_date'];
        }
        if (isset($updateSectionalHeadUserDTO['end_date'])) {
            $data['end_date'] = $updateSectionalHeadUserDTO['end_date'];
        }
        if (isset($updateSectionalHeadUserDTO['is_active'])) {
            $data['is_active'] = $updateSectionalHeadUserDTO['is_active'];
        }

        // Update sectional head assignment
        $sectionalHead->update($data);

        // Load relationships for response
        $sectionalHead->load(['user', 'grade_level']);

        return $sectionalHead;
    }
}
