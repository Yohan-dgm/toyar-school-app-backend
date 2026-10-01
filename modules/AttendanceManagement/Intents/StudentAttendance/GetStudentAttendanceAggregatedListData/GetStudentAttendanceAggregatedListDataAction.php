<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceAggregatedListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;

class GetStudentAttendanceAggregatedListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // StudentAttendance Data Validation
        $getStudentAttendanceListDataUserDTO = GetStudentAttendanceAggregatedListDataUserDTO::validate($payloadArray);

        // Action
        $studentAttendanceAggregatedList = StudentAttendance::where(function (Builder $student_attendance_group1) use ($getStudentAttendanceListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['group_filter'] != '') {
                if ($getStudentAttendanceListDataUserDTO['group_filter'] == 'All') {
                } else {
                    // return $student_attendance_group1->whereHas('student', function (Builder $student_query) use ($getStudentAttendanceListDataUserDTO) {
                    return $student_attendance_group1
                        ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            return $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                        });
                    // });
                    // return $student_attendance_group1->whereHas('student', function (Builder $student_query) use ($getStudentAttendanceListDataUserDTO) {
                    //     return $student_query
                    //         ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //             return $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                    //         });
                    // });
                }
            }
        })->where(function (Builder $student_attendance_group2) use ($getStudentAttendanceListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentAttendanceListDataUserDTO) && ! is_null($getStudentAttendanceListDataUserDTO['search_filter_list']) && count($getStudentAttendanceListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentAttendanceListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'date' && $value != null) {
                        return $student_attendance_group2->where('date', $value);
                    }
                }
            }
        })->where(function (Builder $student_attendance_group3) use ($getStudentAttendanceListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['search_phrase'] != '') {
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
                $perPage = $getStudentAttendanceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentAttendanceListDataUserDTO['page']
            );

        $gradeLevelClass = GradeLevelClass::where('name', $getStudentAttendanceListDataUserDTO['group_filter'])->select('id', 'name', 'grade_level_id')->first();

        if (count($studentAttendanceAggregatedList) > 0) {
            foreach ($studentAttendanceAggregatedList as $attendance_item_key => $attendance_item) {
                if ($getStudentAttendanceListDataUserDTO['group_filter'] == 'All') {
                    // Get all grade level classes that have attendance data for this date
                    $classesWithAttendance = StudentAttendance::where('date', $attendance_item->date)
                        ->with(['grade_level_class' => function (Builder $grade_level_class_query) {
                            $grade_level_class_query->select('id', 'name', 'grade_level_id');
                        }])
                        ->select('grade_level_class_id')
                        ->distinct('grade_level_class_id')
                        ->get()
                        ->map(function ($record) use ($attendance_item) {
                            // Calculate present count for this specific class
                            $presentCount = StudentAttendance::where('date', $attendance_item->date)
                                ->where('grade_level_class_id', $record->grade_level_class_id)
                                ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                    return $attendance_type_query->where('name', 'In');
                                })
                                ->distinct('student_id')
                                ->count();

                            // Calculate absent count for this specific class
                            $absentCount = StudentAttendance::where('date', $attendance_item->date)
                                ->where('grade_level_class_id', $record->grade_level_class_id)
                                ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                                    return $attendance_type_query->where('name', 'Absent');
                                })
                                ->distinct('student_id')
                                ->count();

                            return [
                                'id' => $attendance_item->id,
                                'date' => $attendance_item->date,
                                'created_by' => $attendance_item->created_by,
                                'present_student_count' => $presentCount,
                                'absent_student_count' => $absentCount,
                                'grade_level_class' => [
                                    'id' => $record->grade_level_class->id ?? null,
                                    'name' => $record->grade_level_class->name ?? null,
                                    'grade_level_id' => $record->grade_level_class->grade_level_id ?? null,
                                ],
                                'user' => $attendance_item->user ?? null,
                            ];
                        });

                    // Replace the single item with multiple items (one per class)
                    unset($studentAttendanceAggregatedList[$attendance_item_key]);
                    foreach ($classesWithAttendance as $classAttendance) {
                        $studentAttendanceAggregatedList[] = $classAttendance;
                    }
                } else {
                    $studentAttendanceAggregatedList[$attendance_item_key]['present_student_count'] = StudentAttendance::where('date', $attendance_item->date)
                        ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                            return $attendance_type_query->where('name', 'In');
                        })->whereHas('grade_level_class', function (Builder $student_grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            return $student_grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                        })

                        ->distinct()
                        ->count();

                    // $studentAttendanceAggregatedList[$attendance_item_key]['present_student_count'] = Student::whereHas('grade_level_class', function (Builder $student_grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //     return $student_grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                    // })->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($attendance_item, $getStudentAttendanceListDataUserDTO) {
                    //     return $student_attendance_list_query
                    //         ->where('date', $attendance_item->date)
                    //         ->whereHas('attendance_type', function (Builder $attendance_type_query) use ($attendance_item) {
                    //             return $attendance_type_query->where('name', 'In');
                    //         })->whereHas('grade_level_class', function (Builder $student_grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //             return $student_grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                    //         });
                    // })
                    //     ->distinct()
                    //     ->count();

                    $studentAttendanceAggregatedList[$attendance_item_key]['absent_student_count'] = StudentAttendance::where('date', $attendance_item->date)

                        ->where('date', $attendance_item->date)
                        ->whereHas('attendance_type', function (Builder $attendance_type_query) {
                            return $attendance_type_query->where('name', 'Absent');
                        })->whereHas('grade_level_class', function (Builder $student_grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            return $student_grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                        })
                        ->distinct()
                        ->count();

                    // $studentAttendanceAggregatedList[$attendance_item_key]['absent_student_count'] = Student::whereHas('grade_level_class', function (Builder $student_grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //     return $student_grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                    // })->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($attendance_item, $getStudentAttendanceListDataUserDTO) {
                    //     return $student_attendance_list_query
                    //         ->where('date', $attendance_item->date)
                    //         ->whereHas('attendance_type', function (Builder $attendance_type_query) use ($attendance_item) {
                    //             return $attendance_type_query->where('name', 'Absent');
                    //         })->whereHas('grade_level_class', function (Builder $student_grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                    //             return $student_grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['group_filter']);
                    //         });
                    // })
                    //     ->distinct()
                    //     ->count();
                    $studentAttendanceAggregatedList[$attendance_item_key]['grade_level_class'] = $gradeLevelClass;
                }
            }
        }

        return $studentAttendanceAggregatedList;
    }
}
