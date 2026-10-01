<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\CalendarManagement\Models\Event;
use Modules\CalendarManagement\Models\Holiday;
use Modules\CalendarManagement\Models\SpecialClass;
use Modules\UserManagement\Models\User;

class CalendarManagementController extends Controller
{
    /**
     * Get event list data for calendar
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
    public function getEventListData(Request $request): JsonResponse
    {
        try {
            // Get authenticated user with user types
            $user = $request->user();
            $logInUserId = $user->id;

            // Determine user type from user_type_list relationship
            $userTypes = $user->user_type_list->pluck('name')->toArray();

            // Map user types to the format expected by the visibility logic
            $logInUserType = 'Parent & Guardian'; // Default fallback
            if (in_array('Management', $userTypes) || in_array('Administrator', $userTypes)) {
                $logInUserType = 'Management';
            } elseif (in_array('Educator', $userTypes)) {
                $logInUserType = 'Educator';
            } elseif (in_array('Student', $userTypes)) {
                $logInUserType = 'Student';
            } elseif (in_array('Parent', $userTypes)) {
                $logInUserType = 'Parent';
            } elseif (in_array('Admin', $userTypes)) {
                $logInUserType = 'Accounts';
            }

            // Validate request parameters
            $request->validate([
                'page' => 'integer|min:1',
                'page_size' => 'integer|min:1|max:100',
                'group_filter' => 'string|nullable',
                'search_phrase' => 'string|nullable',
                'search_filter_list' => 'array|nullable',
            ]);

            // Get request parameters with defaults
            $page = $request->input('page', 1);
            $pageSize = $request->input('page_size', 10);
            $groupFilter = $request->input('group_filter');
            $searchPhrase = $request->input('search_phrase');
            $searchFilterList = $request->input('search_filter_list', []);

            // Build the query
            $eventsQuery = Event::where(function (Builder $event_group1) use ($groupFilter, $logInUserId, $logInUserType) {
                // Handle group_filter
                if (! empty($groupFilter) && $groupFilter === 'All') {
                    // No additional filtering for "All"
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
            })->where(function (Builder $event_group2) use ($searchFilterList) {
                // Handle search_filter_list
                if (! empty($searchFilterList)) {
                    foreach ($searchFilterList as $key => $value) {
                        // Add specific filter logic here if needed
                    }
                }
            })->where(function (Builder $event_group3) use ($searchPhrase) {
                // Handle search_phrase
                if (! empty($searchPhrase)) {
                    $event_group3->orWhere('title', 'ILIKE', '%'.$searchPhrase.'%');
                    $event_group3->orWhere('start_date', 'ILIKE', '%'.$searchPhrase.'%');
                    $event_group3->orWhere('end_date', 'ILIKE', '%'.$searchPhrase.'%');

                    $event_group3->orWhereHas('event_category', function (Builder $event_category_query) use ($searchPhrase) {
                        return $event_category_query->where('name', 'ILIKE', '%'.$searchPhrase.'%');
                    });
                }
            });

            // Add relationships
            $eventsQuery->with(['event_category' => function (Builder $event_category_query) {
                $event_category_query->select('id', 'name');
            }])
                ->with(['created_by' => function (Builder $created_by_query) {
                    $created_by_query->select('id', 'full_name');
                }]);

            // Select specific columns
            $eventsQuery->select(
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
            );

            // Apply filters and pagination
            $events = $eventsQuery
                ->where('is_approved', 1)
                ->orderBy('id', 'desc')
                ->paginate($pageSize, ['*'], 'page', $page);

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

            // Get additional data
            $eventCount = DB::table('event')->count();

            // Return response in the expected format
            return response()->json([
                'status' => 'successful',
                'message' => '',
                'data' => array_merge($events->toArray(), [
                    'event_count' => $eventCount,
                ]),
                'metadata' => null,
            ], 200);

        } catch (Exception $e) {
            Log::error('Calendar Events API Error: '.$e->getMessage(), [
                'user_id' => $request->user()->id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'data' => null,
                'metadata' => null,
            ], 500);
        }
    }

    /**
     * Get holiday list data for calendar
     *
     * EXPECTED RESPONSE STRUCTURE:
     * [
     *   {
     *     "id": 1,
     *     "title": "New Year Holiday",
     *     "date": "2025-01-01",                 // Format: YYYY-MM-DD
     *     "description": "New Year celebration holiday",
     *     "created_by_user_id": 5,              // User who created the holiday
     *     "school_id": 1,                       // School identifier
     *     "created_at": "2025-01-15T10:30:00Z", // ISO timestamp
     *     "updated_at": "2025-01-15T10:30:00Z"  // ISO timestamp
     *   }
     * ]
     */
    public function getHolidayListData(Request $request): JsonResponse
    {
        try {
            // Get authenticated user
            $logInUserId = $request->user()->id;

            // Validate request parameters
            $request->validate([
                'page' => 'integer|min:1',
                'page_size' => 'integer|min:1|max:100',
                'group_filter' => 'string|nullable',
                'search_phrase' => 'string|nullable',
                'search_filter_list' => 'array|nullable',
            ]);

            // Get request parameters with defaults
            $page = $request->input('page', 1);
            $pageSize = $request->input('page_size', 10);
            $groupFilter = $request->input('group_filter');
            $searchPhrase = $request->input('search_phrase');
            $searchFilterList = $request->input('search_filter_list', []);

            // Build the query
            $holidaysQuery = Holiday::where(function (Builder $holiday_group1) use ($groupFilter) {
                // Handle group_filter
                if (! empty($groupFilter) && $groupFilter === 'All') {
                    // No additional filtering for "All"
                }
            })->where(function (Builder $holiday_group2) use ($searchFilterList) {
                // Handle search_filter_list
                if (! empty($searchFilterList)) {
                    foreach ($searchFilterList as $key => $value) {
                        // Add specific filter logic here if needed
                    }
                }
            })->where(function (Builder $holiday_group3) use ($searchPhrase) {
                // Handle search_phrase
                if (! empty($searchPhrase)) {
                    $holiday_group3->orWhere('title', 'ILIKE', '%'.$searchPhrase.'%');
                }
            });

            // Select specific columns
            $holidaysQuery->select(
                'id',
                'title',
                'date',
                'description',
                'created_by',
                'created_at',
                'updated_at'
            );

            // Apply pagination
            $holidays = $holidaysQuery
                ->orderBy('id', 'desc')
                ->paginate($pageSize, ['*'], 'page', $page);

            // Transform the data to match expected response structure
            $transformedData = $holidays->getCollection()->map(function ($holiday) {
                return [
                    'id' => $holiday->id,
                    'title' => $holiday->title,
                    'date' => $holiday->date,
                    'description' => $holiday->description,
                    'created_by_user_id' => $holiday->created_by,
                    'school_id' => null, // Not available in current schema - multi-tenant handled by DB connection
                    'created_at' => $holiday->created_at ? $holiday->created_at->toISOString() : null,
                    'updated_at' => $holiday->updated_at ? $holiday->updated_at->toISOString() : null,
                ];
            });

            // Replace the collection with transformed data
            $holidays->setCollection($transformedData);

            // Get additional data
            $holidayCount = DB::table('school_holiday')->count();

            // Return response in the expected format
            return response()->json([
                'status' => 'successful',
                'message' => '',
                'data' => array_merge($holidays->toArray(), [
                    'holiday_count' => $holidayCount,
                ]),
                'metadata' => null,
            ], 200);

        } catch (Exception $e) {
            Log::error('Calendar Holidays API Error: '.$e->getMessage(), [
                'user_id' => $request->user()->id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'data' => null,
                'metadata' => null,
            ], 500);
        }
    }

    /**
     * Get special class list data for calendar
     *
     * EXPECTED RESPONSE STRUCTURE:
     * [
     *   {
     *     "id": 1,
     *     "title": "Extra Math Class",
     *     "program": "Grade 10",                // Program name
     *     "subject": "Mathematics",             // Subject name with code
     *     "special_class_date": "2025-02-15",   // Format: YYYY-MM-DD
     *     "start_time": "09:00:00",             // Format: HH:MM:SS
     *     "end_time": "10:30:00",               // Format: HH:MM:SS
     *     "description": "Additional mathematics class for exam preparation",
     *     "created_by_user_id": 5,              // User who created the special class
     *     "school_id": 1,                       // School identifier
     *     "created_at": "2025-01-15T10:30:00Z", // ISO timestamp
     *     "updated_at": "2025-01-15T10:30:00Z"  // ISO timestamp
     *   }
     * ]
     */
    public function getSpecialClassListData(Request $request): JsonResponse
    {
        try {
            // Get authenticated user
            $logInUserId = $request->user()->id;

            // Validate request parameters
            $request->validate([
                'page' => 'integer|min:1',
                'page_size' => 'integer|min:1|max:100',
                'group_filter' => 'string|nullable',
                'search_phrase' => 'string|nullable',
                'search_filter_list' => 'array|nullable',
            ]);

            // Get request parameters with defaults
            $page = $request->input('page', 1);
            $pageSize = $request->input('page_size', 10);
            $groupFilter = $request->input('group_filter');
            $searchPhrase = $request->input('search_phrase');
            $searchFilterList = $request->input('search_filter_list', []);

            // Build the query
            $specialClassesQuery = SpecialClass::where(function (Builder $specialClass_group1) use ($groupFilter) {
                // Handle group_filter
                if (! empty($groupFilter) && $groupFilter === 'All') {
                    // No additional filtering for "All"
                }
            })->where(function (Builder $specialClass_group2) use ($searchFilterList) {
                // Handle search_filter_list
                if (! empty($searchFilterList)) {
                    foreach ($searchFilterList as $key => $value) {
                        // Add specific filter logic here if needed
                    }
                }
            })->where(function (Builder $specialClass_group3) use ($searchPhrase) {
                // Handle search_phrase
                if (! empty($searchPhrase)) {
                    $specialClass_group3->orWhere('title', 'ILIKE', '%'.$searchPhrase.'%');
                }
            });

            // Add relationships
            $specialClassesQuery->with(['program' => function (Builder $program_query) {
                $program_query->select('id', 'name');
            }])
                ->with(['subject' => function (Builder $subject_query) {
                    $subject_query->select('id', 'name', 'subject_code');
                }]);

            // Select specific columns
            $specialClassesQuery->select(
                'id',
                'title',
                'program_id',
                'subject_id',
                'special_class_date',
                'start_time',
                'end_time',
                'description',
                'created_by',
                'created_at',
                'updated_at'
            );

            // Apply pagination
            $specialClasses = $specialClassesQuery
                ->orderBy('id', 'desc')
                ->paginate($pageSize, ['*'], 'page', $page);

            // Transform the data to match expected response structure
            $transformedData = $specialClasses->getCollection()->map(function ($specialClass) {
                return [
                    'id' => $specialClass->id,
                    'title' => $specialClass->title,
                    'program' => $specialClass->program ? $specialClass->program->name : null,
                    'subject' => $specialClass->subject ? $specialClass->subject->name : null,
                    'special_class_date' => $specialClass->special_class_date,
                    'start_time' => $specialClass->start_time,
                    'end_time' => $specialClass->end_time,
                    'description' => $specialClass->description,
                    'created_by_user_id' => $specialClass->created_by,
                    'school_id' => null, // Not available in current schema - multi-tenant handled by DB connection
                    'created_at' => $specialClass->created_at ? $specialClass->created_at->toISOString() : null,
                    'updated_at' => $specialClass->updated_at ? $specialClass->updated_at->toISOString() : null,
                ];
            });

            // Replace the collection with transformed data
            $specialClasses->setCollection($transformedData);

            // Get additional data
            $specialClassCount = DB::table('special_class')->count();

            // Return response in the expected format
            return response()->json([
                'status' => 'successful',
                'message' => '',
                'data' => array_merge($specialClasses->toArray(), [
                    'special_class_count' => $specialClassCount,
                ]),
                'metadata' => null,
            ], 200);

        } catch (Exception $e) {
            Log::error('Calendar Special Classes API Error: '.$e->getMessage(), [
                'user_id' => $request->user()->id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'data' => null,
                'metadata' => null,
            ], 500);
        }
    }
}
