<?php

namespace Modules\OrganizationManagement\Intents\OrganizationManagement\DetachSchoolDateAttributeListFromSchoolDate;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\OrganizationManagement\Models\SchoolDate;

class DetachSchoolDateAttributeListFromSchoolDateAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $detachSchoolDateAttributeListFromSchoolDateUserDTO = DetachSchoolDateAttributeListFromSchoolDateUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];

        // Final Data Validation
        $detachSchoolDateAttributeListFromSchoolDateDTO = DetachSchoolDateAttributeListFromSchoolDateDTO::validate(array_merge($detachSchoolDateAttributeListFromSchoolDateUserDTO, $system_data));

        // Save In Database
        $school_date = SchoolDate::where(function (Builder $school_date_query) use ($detachSchoolDateAttributeListFromSchoolDateDTO) {
            $school_date_query->where('date', '=', ''.$detachSchoolDateAttributeListFromSchoolDateDTO['date'].'');
        })->first();

        $school_date->school_date_attribute_list()->detach($detachSchoolDateAttributeListFromSchoolDateDTO['school_date_attribute_list']);

        return true;
    }
}
