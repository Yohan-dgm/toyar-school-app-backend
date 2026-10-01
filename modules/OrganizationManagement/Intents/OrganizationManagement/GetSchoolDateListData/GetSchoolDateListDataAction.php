<?php

namespace Modules\OrganizationManagement\Intents\OrganizationManagement\GetSchoolDateListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\OrganizationManagement\Models\SchoolDate;

class GetSchoolDateListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        //  Data Validation
        $getSchoolDateListDataUserDTO = GetSchoolDateListDataUserDTO::validate($payloadArray);

        // Action
        $schoolDateListData = SchoolDate::where(function (Builder $school_date_query_group1) use ($getSchoolDateListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSchoolDateListDataUserDTO) && $getSchoolDateListDataUserDTO['group_filter'] != '') {
                if ($getSchoolDateListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $school_date_query_group2) use ($getSchoolDateListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSchoolDateListDataUserDTO) && ! is_null($getSchoolDateListDataUserDTO['search_filter_list']) && count($getSchoolDateListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSchoolDateListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $schoolDate_query_group3) use ($getSchoolDateListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSchoolDateListDataUserDTO) && $getSchoolDateListDataUserDTO['search_phrase'] != '') {
                $schoolDate_query_group3->where('date', 'ILIKE', '%'.$getSchoolDateListDataUserDTO['search_phrase'].'%');
            }
        })->where(function (Builder $schoolDate_query_group4) {

            $schoolDate_query_group4->whereHas('school_year', function (Builder $school_year_query) {
                // $school_year_query->where('name', $getSchoolDateListDataUserDTO['search_phrase']);
            });
        })
            ->with(['school_year' => function (Builder $school_year_query) {
                //
                $school_year_query->select('id', 'name', 'start_date', 'end_date');
            }])

            ->select(
                'id',
                'school_year_id',
                'date',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getSchoolDateListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSchoolDateListDataUserDTO['page']
            );

        return $schoolDateListData;
    }
}
