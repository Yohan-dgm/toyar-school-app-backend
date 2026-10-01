<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class GetStudentAttendanceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // StudentAttendance Data Validation
        $getStudentAttendanceListDataUserDTO = GetStudentAttendanceListDataUserDTO::validate($payloadArray);

        // Action
        // $studentListData = Student::where(function (Builder $student_query_group1) use ($getStudentAttendanceListDataUserDTO) {
        //     // group_filter
        //     if (array_key_exists('group_filter', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['group_filter'] != "") {
        //         if ($getStudentAttendanceListDataUserDTO['group_filter'] == "All") {
        //             if ($getStudentAttendanceListDataUserDTO['grade_level_class_name'] == "All") {
        //                 return $student_query_group1
        //                     ->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $student_attendance_list_query->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
        //                     });
        //             } else {
        //                 return $student_query_group1
        //                     ->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $student_attendance_list_query->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
        //                         $student_attendance_list_query->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
        //                             $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
        //                         });
        //                     })
        //                     ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
        //                     });
        //             }
        //         } else if ($getStudentAttendanceListDataUserDTO['group_filter'] == "Present") {
        //             if ($getStudentAttendanceListDataUserDTO['grade_level_class_name'] == "All") {
        //                 return $student_query_group1
        //                     ->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $student_attendance_list_query->where('attendance_type_id', 1)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
        //                     });
        //             } else {
        //                 return $student_query_group1
        //                     ->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $student_attendance_list_query->where('attendance_type_id', 1)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
        //                         $student_attendance_list_query->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
        //                             $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
        //                         });
        //                     })
        //                     ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
        //                     });
        //             }
        //         } else if ($getStudentAttendanceListDataUserDTO['group_filter'] == "Absent") {
        //             if ($getStudentAttendanceListDataUserDTO['grade_level_class_name'] == "All") {
        //                 return $student_query_group1
        //                     ->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $student_attendance_list_query->where('attendance_type_id', 4)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
        //                     });
        //             } else {
        //                 return $student_query_group1
        //                     ->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $student_attendance_list_query->where('attendance_type_id', 4)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
        //                         $student_attendance_list_query->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
        //                             $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
        //                         });
        //                     })
        //                     ->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
        //                         $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
        //                     });
        //             }
        //         }
        //     }
        // })->where(function (Builder $student_query_group2) use ($getStudentAttendanceListDataUserDTO) {
        //     // search_filter_list
        //     if (array_key_exists('search_filter_list', $getStudentAttendanceListDataUserDTO) && !is_null($getStudentAttendanceListDataUserDTO['search_filter_list']) && count($getStudentAttendanceListDataUserDTO['search_filter_list']) > 0) {
        //         foreach ($getStudentAttendanceListDataUserDTO['search_filter_list'] as $key => $value) {
        //         }
        //     }
        // })->where(function (Builder $student_query_group3) use ($getStudentAttendanceListDataUserDTO) {
        //     // search_phrase
        //     if (array_key_exists('search_phrase', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['search_phrase'] != "") {
        //         $student_query_group3->where("full_name", "ILIKE", "%" . $getStudentAttendanceListDataUserDTO['search_phrase'] . "%");
        //         $student_query_group3->orWhere("admission_number", "ILIKE", "%" . $getStudentAttendanceListDataUserDTO['search_phrase'] . "%");
        //     }
        // })
        //     ->where(function (Builder $student_query_group4) use ($getStudentAttendanceListDataUserDTO) {
        //         $student_query_group4->whereHas('student_attendance_list', function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //             $student_attendance_list_query->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
        //         });
        //     })
        //     ->with(['student_attendance_list' => function (Builder $student_attendance_list_query) use ($getStudentAttendanceListDataUserDTO) {
        //         //
        //         $student_attendance_list_query->where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])->with(['attendance_type' => function (Builder $attendance_type_query) {
        //             //
        //             $attendance_type_query->select("attendance_type.id", "attendance_type.name");
        //         }])->select("id", "date", "time", "student_id", "attendance_type_id", "notes");
        //     }])

        //     ->select(
        //         "id",
        //         "full_name",
        //         "full_name_with_title",
        //         "admission_number",
        //     )
        //     ->orderBy("full_name", "asc")
        //     ->paginate(
        //         $perPage = $getStudentAttendanceListDataUserDTO["page_size"],
        //         $columns = ['*'],
        //         $pageName = 'page',
        //         $page = $getStudentAttendanceListDataUserDTO["page"]
        //     );

        $studentListData = StudentAttendance::where(function (Builder $student_query_group1) use ($getStudentAttendanceListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['group_filter'] != '') {
                if ($getStudentAttendanceListDataUserDTO['group_filter'] == 'All') {
                    if ($getStudentAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                        $student_query_group1->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
                    } else {
                        $student_query_group1->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
                        $student_query_group1->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                        });
                        $student_query_group1->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                        });
                    }
                } elseif ($getStudentAttendanceListDataUserDTO['group_filter'] == 'Present') {
                    if ($getStudentAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                        $student_query_group1->where('attendance_type_id', 1)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
                    } else {
                        $student_query_group1->where('attendance_type_id', 1)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
                        $student_query_group1->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                        });

                        $student_query_group1->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                        });
                    }
                } elseif ($getStudentAttendanceListDataUserDTO['group_filter'] == 'Absent') {
                    if ($getStudentAttendanceListDataUserDTO['grade_level_class_name'] == 'All') {
                        $student_query_group1->where('attendance_type_id', 4)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
                    } else {
                        $student_query_group1->where('attendance_type_id', 4)->where('date', $getStudentAttendanceListDataUserDTO['attendance_date']);
                        $student_query_group1->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                        });

                        $student_query_group1->whereHas('grade_level_class', function (Builder $grade_level_class_query) use ($getStudentAttendanceListDataUserDTO) {
                            $grade_level_class_query->where('name', $getStudentAttendanceListDataUserDTO['grade_level_class_name']);
                        });
                    }
                }
            }
        })->where(function (Builder $student_query_group2) use ($getStudentAttendanceListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentAttendanceListDataUserDTO) && ! is_null($getStudentAttendanceListDataUserDTO['search_filter_list']) && count($getStudentAttendanceListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentAttendanceListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $student_query_group3) use ($getStudentAttendanceListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentAttendanceListDataUserDTO) && $getStudentAttendanceListDataUserDTO['search_phrase'] != '') {
                $student_query_group3->whereHas('student', function (Builder $student_query_group4) use ($getStudentAttendanceListDataUserDTO) {
                    $student_query_group4->where('full_name', 'ILIKE', '%'.$getStudentAttendanceListDataUserDTO['search_phrase'].'%');
                    $student_query_group4->orWhere('admission_number', 'ILIKE', '%'.$getStudentAttendanceListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->where('date', $getStudentAttendanceListDataUserDTO['attendance_date'])
            // ->where('attendance_type_id', [1, 3, 4])
            ->with(['attendance_type' => function (Builder $attendance_type_query) {
                //
                $attendance_type_query->select('attendance_type.id', 'attendance_type.name');
            }])
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->select(
                    'id',
                    'full_name',
                    'full_name_with_title',
                    'admission_number',
                );
            }])
            ->with(['attendance_reason' => function (Builder $attendance_reason_query) {
                //
                $attendance_reason_query->select('attendance_reasons.id', 'attendance_reasons.attendance_id', 'attendance_reasons.reason');
            }])
            ->select('id', 'date', 'time', 'in_time', 'out_time', 'student_id', 'attendance_type_id', 'notes')

            ->orderBy('student_id', 'desc')
            ->distinct('student_id')
            ->paginate(
                $perPage = $getStudentAttendanceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentAttendanceListDataUserDTO['page']
            );
        for ($i = 0; $i < count($studentListData); $i++) {
            $outStudentAttendance = StudentAttendance::where('student_id', $studentListData[$i]->student_id)
                ->where('attendance_type_id', 2)
                ->where('date', $studentListData[$i]->date)
                ->select('id', 'date', 'time')->first();
            if (! is_null($outStudentAttendance)) {
                $studentListData[$i]->out_time = $outStudentAttendance->time;
            }
            $inStudentAttendance = StudentAttendance::where('student_id', $studentListData[$i]->student_id)
                ->where('attendance_type_id', 1)
                ->where('date', $studentListData[$i]->date)
                ->select('id', 'date', 'time')->first();
            if (! is_null($outStudentAttendance)) {
                $studentListData[$i]->in_time = $inStudentAttendance->time;
            }
        }

        return $studentListData;
    }
}
