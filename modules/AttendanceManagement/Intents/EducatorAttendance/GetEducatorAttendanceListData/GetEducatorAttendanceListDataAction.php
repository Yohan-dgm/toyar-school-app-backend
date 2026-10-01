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
            if (array_key_exists('group_filter', $getEducatorAttendanceListDataUserDTO) && $getEducatorAttendanceListDataUserDTO['group_filter'] != '') {
                if ($getEducatorAttendanceListDataUserDTO['group_filter'] == 'All') {
                    if ($getEducatorAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                    } else {
                        return $educator_query_group1
                            ->whereHas('grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                                $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                            });
                    }
                } elseif ($getEducatorAttendanceListDataUserDTO['group_filter'] == 'Present') {
                    if ($getEducatorAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                        return $educator_query_group1
                            ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) {
                                $educator_attendance_list_query->where('attendance_type_id', 1);
                            });
                    } else {
                        return $educator_query_group1
                            ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) {
                                $educator_attendance_list_query->where('attendance_type_id', 1);
                            })
                            ->whereHas('grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                                $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                            });
                    }
                } elseif ($getEducatorAttendanceListDataUserDTO['group_filter'] == 'Absent') {
                    if ($getEducatorAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                        return $educator_query_group1
                            ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) {
                                $educator_attendance_list_query->where('attendance_type_id', 4);
                            });
                    } else {
                        return $educator_query_group1
                            ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) {
                                $educator_attendance_list_query->where('attendance_type_id', 4);
                            })
                            ->whereHas('grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                                $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                            });
                    }
                } elseif ($getEducatorAttendanceListDataUserDTO['group_filter'] == 'Leave') {
                    if ($getEducatorAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                        return $educator_query_group1
                            ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) {
                                $educator_attendance_list_query->where('attendance_type_id', 3);
                            });
                    } else {
                        return $educator_query_group1
                            ->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) {
                                $educator_attendance_list_query->where('attendance_type_id', 3);
                            })
                            ->whereHas('grade_level_class_list', function (Builder $grade_level_class_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                                $grade_level_class_list_query->where('name', $getEducatorAttendanceListDataUserDTO['grade_level_class_name']);
                            });
                    }
                }
            }
        })->where(function (Builder $educator_query_group2) use ($getEducatorAttendanceListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getEducatorAttendanceListDataUserDTO) && ! is_null($getEducatorAttendanceListDataUserDTO['search_filter_list']) && count($getEducatorAttendanceListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEducatorAttendanceListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $educator_query_group3) use ($getEducatorAttendanceListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getEducatorAttendanceListDataUserDTO) && $getEducatorAttendanceListDataUserDTO['search_phrase'] != '') {
                return $educator_query_group3->whereHas('employee', function (Builder $employee_query) use ($getEducatorAttendanceListDataUserDTO) {
                    $employee_query->where('full_name', $getEducatorAttendanceListDataUserDTO['search_phrase']);
                });
            }
        })->where(function (Builder $educator_query_group4) use ($getEducatorAttendanceListDataUserDTO) {
            //
            return $educator_query_group4->whereHas('educator_attendance_list', function (Builder $educator_attendance_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                $educator_attendance_list_query->where('date', $getEducatorAttendanceListDataUserDTO['attendance_date']);
            });
        })
            ->with(['educator_attendance_list' => function (Builder $educator_attendance_list_query) use ($getEducatorAttendanceListDataUserDTO) {
                //
                $educator_attendance_list_query->where('date', $getEducatorAttendanceListDataUserDTO['attendance_date'])->with(['attendance_type' => function (Builder $attendance_type_query) {
                    //
                    $attendance_type_query->select('attendance_type.id', 'attendance_type.name');
                }])->select('id', 'date', 'time', 'educator_id', 'attendance_type_id');
            }])
            ->with(['employee' => function (Builder $employee_query) {
                //
                $employee_query->select('id', 'full_name');
            }])
            ->join('employee', 'employee.id', '=', 'educator.employee_id')
            ->select(
                'educator.id as id',
                'employee.id as joined_employee_id',
                'employee_id',
            )
            ->orderBy('employee.full_name', 'asc')
            ->paginate(
                $perPage = $getEducatorAttendanceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEducatorAttendanceListDataUserDTO['page']
            );

        return $educatorListData;
    }
}
