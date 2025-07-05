<?php

namespace Modules\CalendarManagement\Intents\Event\GetEventListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Event;

class GetEventListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Event Data Validation
        $getEventListDataUserDTO = GetEventListDataUserDTO::validate($payloadArray);
        $logInUserId = $getEventListDataUserDTO['logInUserId'];
        $logInUserType = $getEventListDataUserDTO['logInUserType'];
        // var_dump($getEventListDataUserDTO);
        // Action
        $event = Event::where(function (Builder $event_group1) use ($getEventListDataUserDTO, $logInUserId, $logInUserType) {
            // Handle group_filter
            if (!empty($getEventListDataUserDTO['group_filter']) && $getEventListDataUserDTO['group_filter'] === "All") {
            }
            $event_group1->where(function (Builder $visibilityQuery) use ($logInUserId, $logInUserType) {

                // if (!empty($logInUserId) && !empty($logInUserType)) {
                $visibilityQuery
                    ->where('visibility_type', 'Public')
                    ->orWhere(function (Builder $privateQuery) use ($logInUserId) {
                        $privateQuery->where('visibility_type', 'Private')
                            ->where('created_by', $logInUserId);
                    })
                    ->orWhere(function (Builder $userCreatedQuery) use ($logInUserId) {
                        // Any events created by the current user (regardless of visibility type)
                        $userCreatedQuery->where('created_by', $logInUserId);
                    })
                    // ->orWhere(function (Builder $deptQuery) use ($logInUserType) {
                    //     if ($logInUserType == "Management") {
                    //         $deptQuery->where('visibility_type', 'All Management')
                    //             ->orwhere('visibility_type', "All Management & Educator");
                    //     }
                    // });
                    ->orWhere(function (Builder $q) use ($logInUserType) {
                        $q->where(function ($roleQuery) use ($logInUserType) {
                            $roleQuery->where(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'All Management')
                                    ->whereRaw("'$logInUserType' = 'Management'");
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'All Educator')
                                    ->whereRaw("'$logInUserType' = 'Educator'");
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'All Student')
                                    ->whereRaw("'$logInUserType' = 'Student'");
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'All Management & Educator')
                                    ->whereIn(DB::raw("'$logInUserType'"), ['Management', 'Educator']);
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'All Student & Educator')
                                    ->whereIn(DB::raw("'$logInUserType'"), ['Student', 'Educator']);
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'Accountant')
                                    ->whereRaw("'$logInUserType' = 'Accounts'");
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'Parent & Guardian')
                                    ->whereRaw("'$logInUserType' = 'Parent'");
                            });
                        });
                    });
                // }
            });
        })->where(function (Builder $event_group2) use ($getEventListDataUserDTO) {
            // Handle search_filter_list
            if (!empty($getEventListDataUserDTO['search_filter_list'])) {
                foreach ($getEventListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $event_group3) use ($getEventListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getEventListDataUserDTO) && $getEventListDataUserDTO['search_phrase'] != "") {

                $event_group3->orWhere("title", "ILIKE", "%" . $getEventListDataUserDTO['search_phrase'] . "%");
                $event_group3->orWhere("start_date", "ILIKE", "%" . $getEventListDataUserDTO['search_phrase'] . "%");
                $event_group3->orWhere("end_date", "ILIKE", "%" . $getEventListDataUserDTO['search_phrase'] . "%");

                $event_group3->orWhereHas('event_category', function (Builder $event_category_query) use ($getEventListDataUserDTO) {
                    return $event_category_query->where('name', "ILIKE", "%" . $getEventListDataUserDTO['search_phrase'] . "%");
                });
            }
            // $event_group3->where('visibility_type', "Private");
        })
            ->with(['event_category' => function (Builder $event_category_query) {
                //
                $event_category_query->select("id", "name");
            }])
            ->with(['created_by' => function (Builder $created_by_query) {
                //
                $created_by_query->select("id", "full_name");
            }])

            ->select(
                'id',
                'created_by',
                'title',
                'event_category_id',
                'start_date',
                'start_time',
                'end_date',
                'end_time',
                'description',
                'visibility_type',
                'is_approved',
                'request_visibility_type',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getEventListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEventListDataUserDTO["page"]
            );
        return $event;
    }
}
