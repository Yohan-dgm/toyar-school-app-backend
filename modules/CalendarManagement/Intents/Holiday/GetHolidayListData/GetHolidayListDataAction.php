<?php

namespace Modules\CalendarManagement\Intents\Holiday\GetHolidayListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Holiday;

class GetHolidayListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Holiday Data Validation
        $getHolidayListDataUserDTO = GetHolidayListDataUserDTO::validate($payloadArray);

        // Action
        $holiday = Holiday::where(function (Builder $holiday_group1) use ($getHolidayListDataUserDTO) {
            // Handle group_filter
            if (!empty($getHolidayListDataUserDTO['group_filter']) && $getHolidayListDataUserDTO['group_filter'] === "All") {
            }
        })->where(function (Builder $holiday_group2) use ($getHolidayListDataUserDTO) {
            // Handle search_filter_list
            if (!empty($getHolidayListDataUserDTO['search_filter_list'])) {
                foreach ($getHolidayListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $holiday_group3) use ($getHolidayListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getHolidayListDataUserDTO) && $getHolidayListDataUserDTO['search_phrase'] != "") {

                $holiday_group3->orWhere("title", "ILIKE", "%" . $getHolidayListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                'id',
                'title',
                'date',
                'description',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getHolidayListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getHolidayListDataUserDTO["page"]
            );
        return $holiday;
    }
}
