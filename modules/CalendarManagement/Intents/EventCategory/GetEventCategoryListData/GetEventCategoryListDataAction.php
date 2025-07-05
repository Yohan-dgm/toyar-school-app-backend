<?php

namespace Modules\CalendarManagement\Intents\EventCategory\GetEventCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\EventCategory;

class GetEventCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // EventCategory Data Validation
        $getEventCategoryListDataUserDTO = GetEventCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $event_category = EventCategory::where(function (Builder $event_category_group1) use ($getEventCategoryListDataUserDTO) {
            // Handle group_filter
            if (!empty($getEventCategoryListDataUserDTO['group_filter']) && $getEventCategoryListDataUserDTO['group_filter'] === "All") {
            }
        })->where(function (Builder $event_category_group2) use ($getEventCategoryListDataUserDTO) {
            // Handle search_filter_list
            if (!empty($getEventCategoryListDataUserDTO['search_filter_list'])) {
                foreach ($getEventCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $event_category_group3) use ($getEventCategoryListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getEventCategoryListDataUserDTO) && $getEventCategoryListDataUserDTO['search_phrase'] != "") {

                $event_category_group3->orWhere("name", "ILIKE", "%" . $getEventCategoryListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getEventCategoryListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEventCategoryListDataUserDTO["page"]
            );
        return $event_category;
    }
}
