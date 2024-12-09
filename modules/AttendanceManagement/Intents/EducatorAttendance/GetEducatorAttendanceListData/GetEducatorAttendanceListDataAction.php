<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\Educator;

class GetEducatorAttendanceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // EducatorAttendance Data Validation
        $getEducatorAttendanceListDataUserDTO = GetEducatorAttendanceListDataUserDTO::validate($payloadArray);

        // Action
        $educatorListData = Educator::where(function (Builder $educator_query_group1) use ($getEducatorAttendanceListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getEducatorAttendanceListDataUserDTO) && $getEducatorAttendanceListDataUserDTO['group_filter'] != "") {
                if ($getEducatorAttendanceListDataUserDTO['group_filter'] == "All") {
                } else {
                }
            }
        })->where(function (Builder $educator_query_group2) use ($getEducatorAttendanceListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getEducatorAttendanceListDataUserDTO) && count($getEducatorAttendanceListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEducatorAttendanceListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $educator_query_group3) use ($getEducatorAttendanceListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getEducatorAttendanceListDataUserDTO) && $getEducatorAttendanceListDataUserDTO['search_phrase'] != "") {
                $educator_query_group3->where("name", "ILIKE", "%" . $getEducatorAttendanceListDataUserDTO['search_phrase'] . "%");
            }
        })->where(function (Builder $educator_query_group4) use ($getEducatorAttendanceListDataUserDTO) {
            //
            $educator_query_group4->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                $educator_attendance_list_query->where('date', $getEducatorAttendanceListDataUserDTO['attendance_date']);
            });
        })
            ->with(['educator_attendance_list' => function (Builder $educator_attendance_list_query) {
                //
                $educator_attendance_list_query->with(['attendance_type' => function (Builder $attendance_type_query) {
                    //
                    $attendance_type_query->select("attendance_type.id", "attendance_type.name");
                }])->select("id", "date", "time", "educator_id", "attendance_type_id");
            }])

            ->select(
                "id",
                "name",
            )
            ->orderBy("id", "desc")
            ->paginate(
                $perPage = $getEducatorAttendanceListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEducatorAttendanceListDataUserDTO["page"]
            );
        return $educatorListData;
    }
}
