<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceAggregatedListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;
use Modules\EducatorManagement\Models\Educator;

class GetEducatorAttendanceAggregatedListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // EducatorAttendance Data Validation
        $getEducatorAttendanceListDataUserDTO = GetEducatorAttendanceAggregatedListDataUserDTO::validate($payloadArray);

        // Action
        $educatorAttendanceAggregatedList = EducatorAttendance::where(function (Builder $educator_attendance_group1) use ($getEducatorAttendanceListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getEducatorAttendanceListDataUserDTO) && $getEducatorAttendanceListDataUserDTO['group_filter'] != '') {
                if ($getEducatorAttendanceListDataUserDTO['group_filter'] == 'All') {
                } else {
                    return $educator_attendance_group1->whereHas('educator', function (Builder $educator_query) use ($getEducatorAttendanceListDataUserDTO) {
                        return $educator_query->whereHas('grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                            return $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['group_filter']);
                        });
                    });
                }
            }
        })->where(function (Builder $educator_attendance_group2) use ($getEducatorAttendanceListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getEducatorAttendanceListDataUserDTO) && ! is_null($getEducatorAttendanceListDataUserDTO['search_filter_list']) && count($getEducatorAttendanceListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEducatorAttendanceListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'date' && $value != null) {
                        return $educator_attendance_group2->where('date', $value);
                    }
                }
            }
        })->where(function (Builder $educator_attendance_group3) use ($getEducatorAttendanceListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getEducatorAttendanceListDataUserDTO) && $getEducatorAttendanceListDataUserDTO['search_phrase'] != '') {
            }
        })
            ->with(['user' => function (Builder $user_query) {
                //
                $user_query->select('id', 'full_name');
            }])
            ->select(
                'id',
                'date',
                'created_by',
            )
            ->distinct('date')
            ->orderBy('date', 'desc')
            ->paginate(
                $perPage = $getEducatorAttendanceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEducatorAttendanceListDataUserDTO['page']
            );

        if (count($educatorAttendanceAggregatedList) > 0) {
            foreach ($educatorAttendanceAggregatedList as $attendance_item_key => $attendance_item) {
                if ($getEducatorAttendanceListDataUserDTO['group_filter'] == 'All') {
                    $educatorAttendanceAggregatedList[$attendance_item_key]['present_educator_count'] = Educator::whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($attendance_item) {
                        return $educator_attendance_list_query
                            ->where('date', $attendance_item->date)
                            ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                return $attendance_type_query->where('name', 'In');
                            });
                    })
                        ->distinct()
                        ->count();
                    $educatorAttendanceAggregatedList[$attendance_item_key]['absent_educator_count'] = Educator::whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($attendance_item) {
                        return $educator_attendance_list_query
                            ->where('date', $attendance_item->date)
                            ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                return $attendance_type_query->where('name', 'Absent');
                            });
                    })
                        ->distinct()
                        ->count();
                    $educatorAttendanceAggregatedList[$attendance_item_key]['on_leave_educator_count'] = Educator::whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($attendance_item) {
                        return $educator_attendance_list_query
                            ->where('date', $attendance_item->date)
                            ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                return $attendance_type_query->where('name', 'Leave');
                            });
                    })
                        ->distinct()
                        ->count();
                    $educatorAttendanceAggregatedList[$attendance_item_key]['grade_level_class'] = ['name' => 'All'];
                } else {
                    $educatorAttendanceAggregatedList[$attendance_item_key]['present_educator_count'] = Educator::whereHas('grade_level_class_list', function (Builder $educator_grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                        return $educator_grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['group_filter']);
                    })
                        ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($attendance_item) {
                            return $educator_attendance_list_query
                                ->where('date', $attendance_item->date)
                                ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                    return $attendance_type_query->where('name', 'In');
                                });
                        })
                        ->distinct()
                        ->count();
                    $educatorAttendanceAggregatedList[$attendance_item_key]['absent_educator_count'] = Educator::whereHas('grade_level_class_list', function (Builder $educator_grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                        return $educator_grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['group_filter']);
                    })
                        ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($attendance_item) {
                            return $educator_attendance_list_query
                                ->where('date', $attendance_item->date)
                                ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                    return $attendance_type_query->where('name', 'Absent');
                                });
                        })
                        ->distinct()
                        ->count();
                    $educatorAttendanceAggregatedList[$attendance_item_key]['on_leave_educator_count'] = Educator::whereHas('grade_level_class_list', function (Builder $educator_grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                        return $educator_grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['group_filter']);
                    })
                        ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($attendance_item) {
                            return $educator_attendance_list_query
                                ->where('date', $attendance_item->date)
                                ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                    return $attendance_type_query->where('name', 'Leave');
                                });
                        })
                        ->distinct()
                        ->count();
                    $educatorAttendanceAggregatedList[$attendance_item_key]['grade_level_class'] = ['name' => $getEducatorAttendanceListDataUserDTO['group_filter']];
                }
            }
        }

        return $educatorAttendanceAggregatedList;
    }
}
