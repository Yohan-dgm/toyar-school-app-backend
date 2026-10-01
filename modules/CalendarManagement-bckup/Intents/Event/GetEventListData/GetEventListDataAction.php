<?php

namespace Modules\CalendarManagement\Intents\Event\GetEventListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Event;

class GetEventListDataAction
{
    use AsAction;

    /**
     * Handle the event list data retrieval
     *
     * EXPECTED RESPONSE STRUCTURE:
     * [
     *   {
     *     "id": 1,
     *     "title": "School Sports Day",
     *     "description": "Annual sports competition for all grades",
     *     "start_date": "2025-02-15",           // Format: YYYY-MM-DD
     *     "end_date": "2025-02-15",             // Format: YYYY-MM-DD (can be same as start_date)
     *     "start_time": "09:00:00",             // Format: HH:MM:SS (optional)
     *     "end_time": "16:00:00",               // Format: HH:MM:SS (optional)
     *     "event_category": "Sports",           // Category for filtering/grouping
     *     "visibility_type": "Public",          // "Public", "Private", "Parent & Guardian"
     *     "created_by_user_id": 5,              // User who created the event
     *     "school_id": 1,                       // School identifier
     *     "location": "Main Playground",        // Event location (optional)
     *     "created_at": "2025-01-15T10:30:00Z", // ISO timestamp
     *     "updated_at": "2025-01-15T10:30:00Z"  // ISO timestamp
     *   }
     * ]
     */
    public function handle($payloadArray, $actionData)
    {
        // Event Data Validation
        $getEventListDataUserDTO = GetEventListDataUserDTO::validate($payloadArray);
        $logInUserId = 43;
        $logInUserType = 'Parent & Guardian';

        // Action
        $events = Event::where(function (Builder $event_group1) use ($getEventListDataUserDTO, $logInUserId, $logInUserType) {
            // Handle group_filter
            if (! empty($getEventListDataUserDTO['group_filter']) && $getEventListDataUserDTO['group_filter'] === 'All') {
            }
            $event_group1->where(function (Builder $visibilityQuery) use ($logInUserId, $logInUserType) {

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
            });
        })->where(function (Builder $event_group2) use ($getEventListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getEventListDataUserDTO['search_filter_list'])) {
                foreach ($getEventListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $event_group3) use ($getEventListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getEventListDataUserDTO) && $getEventListDataUserDTO['search_phrase'] != '') {

                $event_group3->orWhere('title', 'ILIKE', '%'.$getEventListDataUserDTO['search_phrase'].'%');
                $event_group3->orWhere('start_date', 'ILIKE', '%'.$getEventListDataUserDTO['search_phrase'].'%');
                $event_group3->orWhere('end_date', 'ILIKE', '%'.$getEventListDataUserDTO['search_phrase'].'%');

                $event_group3->orWhereHas('event_category', function (Builder $event_category_query) use ($getEventListDataUserDTO) {
                    return $event_category_query->where('name', 'ILIKE', '%'.$getEventListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['event_category' => function (Builder $event_category_query) {
                $event_category_query->select('id', 'name');
            }])
            ->with(['created_by' => function (Builder $created_by_query) {
                $created_by_query->select('id', 'full_name');
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
                'created_at',
                'updated_at'
            )
            ->where('is_approved', 1)
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getEventListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEventListDataUserDTO['page']
            );

        // Transform the data to match expected response structure
        $transformedData = $events->getCollection()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'event_category' => $event->event_category ? $event->event_category->name : null,
                'visibility_type' => $event->visibility_type,
                'created_by_user_id' => $event->created_by,
                'school_id' => null, // Not available in current schema - multi-tenant handled by DB connection
                'location' => null, // Not available in current schema
                'created_at' => $event->created_at ? $event->created_at->toISOString() : null,
                'updated_at' => $event->updated_at ? $event->updated_at->toISOString() : null,
            ];
        });

        // Replace the collection with transformed data
        $events->setCollection($transformedData);

        return $events;
    }
}
