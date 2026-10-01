<?php

namespace Modules\OrganizationManagement\Intents\OrganizationManagement\AttachSchoolDateAttributeToSchoolDate;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\OrganizationManagement\Models\SchoolDate;

class AttachSchoolDateAttributeToSchoolDateAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $attachSchoolDateAttributeToSchoolDateUserDTO = AttachSchoolDateAttributeToSchoolDateUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // Final Data Validation
        $attachSchoolDateAttributeToSchoolDateDTO = AttachSchoolDateAttributeToSchoolDateDTO::validate(array_merge($attachSchoolDateAttributeToSchoolDateUserDTO, $system_data));

        // Save In Database
        $attachData = [
            'created_by' => $actionData['created_by'],
            'created_at' => Carbon::now(),
        ];

        $date_selection_type = '';
        if ($attachSchoolDateAttributeToSchoolDateDTO['date_selection_type'] == '1 Day') {
            $date_selection_type = '1 Day';
        } elseif ($attachSchoolDateAttributeToSchoolDateDTO['date_selection_type'] == 'Period') {
            if ($attachSchoolDateAttributeToSchoolDateDTO['period_start_date'] == $attachSchoolDateAttributeToSchoolDateDTO['period_end_date']) {
                $date_selection_type = '1 Day';
            } else {
                $date_selection_type = 'Period';
            }
        }
        if ($date_selection_type == '1 Day') {
            $school_date = SchoolDate::where(function (Builder $school_date_query) use ($attachSchoolDateAttributeToSchoolDateDTO) {
                $school_date_query->where('date', '=', ''.$attachSchoolDateAttributeToSchoolDateDTO['date'].'');
            })->first();

            $school_date->school_date_attribute_list()->syncWithoutDetaching($attachSchoolDateAttributeToSchoolDateDTO['school_date_attribute_id'], $attachData);
        } elseif ($date_selection_type == 'Period') {

            $school_date_list = SchoolDate::where(function (Builder $school_date_query) use ($attachSchoolDateAttributeToSchoolDateDTO) {
                $school_date_query->whereBetween('date', [$attachSchoolDateAttributeToSchoolDateDTO['period_start_date'], $attachSchoolDateAttributeToSchoolDateDTO['period_end_date']]);
            })->get();

            if (count($school_date_list) > 0) {
                foreach ($school_date_list as $school_date) {
                    $school_date->school_date_attribute_list()->syncWithoutDetaching($attachSchoolDateAttributeToSchoolDateDTO['school_date_attribute_id'], $attachData);
                }
            }
        }

        return true;
    }
}
