<?php

namespace Modules\CalendarManagement\Intents\Calendar\GetCalendarDataByMonth;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\Event;
use Modules\CalendarManagement\Models\Holiday;
use Modules\CalendarManagement\Models\SpecialClass;
use Modules\UserManagement\Models\User;

class GetCalendarDataByMonthAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getCalendarDataByMonthUserDTO = GetCalendarDataByMonthUserDTO::validate($payloadArray);
        $logInUserId = $actionData['user_id'] ?? null;

        // Get user category from user_id
        $logInUserType = null;
        if ($logInUserId) {
            $user = User::find($logInUserId);
            $logInUserType = $user ? $user->user_category : null;
        }

        // Parse the month (format: YYYY-MM)
        $monthDate = Carbon::createFromFormat('Y-m', $getCalendarDataByMonthUserDTO['month']);
        $startDate = $monthDate->startOfMonth()->toDateString();
        $endDate = $monthDate->endOfMonth()->toDateString();

        // Get Events for the month
        $events = Event::where(function (Builder $event_query) use ($startDate, $endDate) {
            $event_query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function (Builder $overlap_query) use ($startDate, $endDate) {
                    $overlap_query->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        })->where(function (Builder $visibility_query) use ($logInUserId, $logInUserType) {
            if ($logInUserId && $logInUserType) {
                $visibility_query
                    ->where('visibility_type', 'Public')
                    ->orWhere(function (Builder $private_query) use ($logInUserId) {
                        $private_query->where('visibility_type', 'Private')
                            ->where('created_by', $logInUserId);
                    })
                    ->orWhere(function (Builder $user_created_query) use ($logInUserId) {
                        $user_created_query->where('created_by', $logInUserId);
                    })
                    ->orWhere(function (Builder $role_query) use ($logInUserType) {
                        $role_query->where(function ($roleQuery) use ($logInUserType) {
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
                                    ->whereIn(\Illuminate\Support\Facades\DB::raw("'$logInUserType'"), ['Management', 'Educator']);
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'All Student & Educator')
                                    ->whereIn(\Illuminate\Support\Facades\DB::raw("'$logInUserType'"), ['Student', 'Educator']);
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'Accountant')
                                    ->whereRaw("'$logInUserType' = 'Accounts'");
                            })->orWhere(function ($sub) use ($logInUserType) {
                                $sub->where('visibility_type', 'Parent & Guardian')
                                    ->whereRaw("'$logInUserType' = 'Parent'");
                            });
                        });
                    });
            }
        })
            ->with(['event_category' => function (Builder $event_category_query) {
                $event_category_query->select('id', 'name');
            }])
            ->select(
                'id',
                'title',
                'event_category_id',
                'start_date',
                'start_time',
                'end_date',
                'end_time',
                'description',
                'visibility_type'
            )
            ->orderBy('start_date', 'asc')
            ->get();

        // Get Holidays for the month
        $holidays = Holiday::whereBetween('date', [$startDate, $endDate])
            ->select(
                'id',
                'title',
                'date',
                'description'
            )
            ->orderBy('date', 'asc')
            ->get();

        // Get Special Classes for the month
        $specialClasses = SpecialClass::whereBetween('special_class_date', [$startDate, $endDate])
            ->with(['program' => function (Builder $program_query) {
                $program_query->select('id', 'name');
            }])
            ->with(['subject' => function (Builder $subject_query) {
                $subject_query->select('id', 'name', 'subject_code');
            }])
            ->select(
                'id',
                'title',
                'program_id',
                'subject_id',
                'special_class_date',
                'start_time',
                'end_time',
                'description'
            )
            ->orderBy('special_class_date', 'asc')
            ->get();

        return [
            'events' => $events->toArray(),
            'holidays' => $holidays->toArray(),
            'special_classes' => $specialClasses->toArray(),
            'month' => $getCalendarDataByMonthUserDTO['month'],
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
