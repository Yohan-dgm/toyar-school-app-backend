<?php

namespace Modules\CalendarManagement\Intents\CalendarDashboard\GetCalendarDashboardListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Event;

class GetCalendarDashboardListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // CalendarDashboard Data Validation
        $getCalendarDashboardListDataUserDTO = GetCalendarDashboardListDataUserDTO::validate($payloadArray);

        // Action1
        $event = Event::where(function (Builder $event_group1) use ($getCalendarDashboardListDataUserDTO) {
            // Handle group_filter
            if (!empty($getCalendarDashboardListDataUserDTO['group_filter']) && $getCalendarDashboardListDataUserDTO['group_filter'] === "All") {
            }
        })->where(function (Builder $event_group2) use ($getCalendarDashboardListDataUserDTO) {
            // Handle search_filter_list
            if (!empty($getCalendarDashboardListDataUserDTO['search_filter_list'])) {
                foreach ($getCalendarDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $event_group3) use ($getCalendarDashboardListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getCalendarDashboardListDataUserDTO) && $getCalendarDashboardListDataUserDTO['search_phrase'] != "") {

                $event_group3->orWhere("title", "ILIKE", "%" . $getCalendarDashboardListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                'id',
                'title',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getCalendarDashboardListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCalendarDashboardListDataUserDTO["page"]
            );
        return $event;
    }
}
