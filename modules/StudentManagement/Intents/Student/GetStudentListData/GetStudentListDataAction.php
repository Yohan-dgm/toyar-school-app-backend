<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;
use Modules\StudentManagement\Models\Student;

class GetStudentListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Student Data Validation
        $getStudentListDataUserDTO = GetStudentListDataUserDTO::validate($payloadArray);

        // Action
        $studentListData = Student::where(function (Builder $student_query_group1) use ($getStudentListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentListDataUserDTO) && $getStudentListDataUserDTO['group_filter'] != '') {
                if ($getStudentListDataUserDTO['group_filter'] == 'All') {
                    $student_query_group1->where('has_dropped_out', false)->where('is_school_leaver', false);
                } elseif ($getStudentListDataUserDTO['group_filter'] == 'School Dropped Out') {
                    $student_query_group1->where('has_dropped_out', true);
                } elseif ($getStudentListDataUserDTO['group_filter'] == 'School Leavers') {
                    $student_query_group1->where('is_school_leaver', true);
                } elseif ($getStudentListDataUserDTO['group_filter'] == 'Incomplete') {
                    $student_query_group1->whereNull('father_full_name')
                        ->whereNull('mother_full_name')
                        ->whereNull('guardian_full_name');
                } elseif ($getStudentListDataUserDTO['group_filter'] == 'Incompl. Address') {
                    $student_query_group1->whereNull('student_address')
                        ->orWhere('student_address', '')
                        ->orWhere('student_address', '<p></p>');
                } elseif ($getStudentListDataUserDTO['group_filter'] == 'Incompl. Photo') {
                    $student_query_group1->where('has_dropped_out', false)->where('is_school_leaver', false)->doesntHave('student_attachment_list');
                } elseif ($getStudentListDataUserDTO['group_filter'] == 'Calypso' || $getStudentListDataUserDTO['group_filter'] == 'Eurus' || $getStudentListDataUserDTO['group_filter'] == 'Tellus' || $getStudentListDataUserDTO['group_filter'] == 'Vulcan') {
                    $student_query_group1->where('has_dropped_out', false)->where('is_school_leaver', false)->whereHas('school_house', function (Builder $school_house_query) use ($getStudentListDataUserDTO) {
                        return $school_house_query->where('name', '=', $getStudentListDataUserDTO['group_filter']);
                    });
                } else {
                    // $student_query_group1->where('has_dropped_out', false)->whereHas('grade_level', function (Builder $grade_level_query) use ($getStudentListDataUserDTO) {
                    //     return $grade_level_query->where('name', '=', $getStudentListDataUserDTO['group_filter']);
                    // });
                    $student_query_group1->where('has_dropped_out', false)->where('is_school_leaver', false)->whereHas('grade_level', function (Builder $grade_level_query) use ($getStudentListDataUserDTO) {
                        return $grade_level_query->where('name', '=', $getStudentListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $student_query_group2) use ($getStudentListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentListDataUserDTO) && ! is_null($getStudentListDataUserDTO['search_filter_list']) && count($getStudentListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'drop_student') {
                        foreach ($value as $key2 => $value2) {
                            $student_query_group2->whereNot('id', $value2['student']['id']);
                        }
                    } else {
                        $student_query_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $student_query_group3) use ($getStudentListDataUserDTO, $actionData) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentListDataUserDTO) && $getStudentListDataUserDTO['search_phrase'] != '') {
                $student_query_group3->where('full_name', 'ILIKE', '%'.$getStudentListDataUserDTO['search_phrase'].'%');
                $student_query_group3->orWhere('admission_number', 'ILIKE', '%'.$getStudentListDataUserDTO['search_phrase'].'%');

                // create student activity log
                $logData['description'] = '[Status: Search Student, IP: '.$_SERVER['REMOTE_ADDR'].', User: '.$actionData['username'].', Search Phrase: '.$getStudentListDataUserDTO['search_phrase'].', User: '.$actionData['username'].'] ';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }
        })
            ->with(['grade_level' => function (Builder $grade_level_query) {
                //
                $grade_level_query->with(['school_fee_list' => function (Builder $school_fee_list_query) {
                    //
                    $school_fee_list_query->select('id', 'school_fee_type', 'grade_level_id', 'amount', 'is_active');
                }]);
                $grade_level_query->select('id', 'name');
            }])
            ->with(['school_house' => function (Builder $school_house_query) {
                //
                $school_house_query->select('id', 'name');
            }])
        //     ->with(['student_admission_source' => function (Builder $student_admission_source_query) {
        //         //
        //         $student_admission_source_query->select("id", "name");
        //     }])
            ->with(['student_attachment_list' => function (Builder $student_attachment_list_query) {
                //
                $student_attachment_list_query->select('id', 'student_id', 'file_name', 'original_file_name', 'mime_type');
            }])
        //     ->with(['receipt_voucher_list' => function (Builder $receipt_voucher_list_query) {
        //         //
        //         $receipt_voucher_list_query->where('is_active', true)->with(['student' => function (Builder $student_query) {
        //             //
        //             $student_query->select("id", "full_name_with_title", "admission_number");
        //         }])
        //             ->with(['applicant' => function (Builder $applicant_query) {
        //                 //
        //                 $applicant_query->select("id", "full_name_with_title", "applicant_number");
        //             }])
        //             ->with(['exam_private_candidate' => function (Builder $exam_private_candidate_query) {
        //                 //
        //                 $exam_private_candidate_query->select("id", "full_name_with_title", "exam_private_candidate_number");
        //             }])
        //             ->with(['private_candidate' => function (Builder $private_candidate_query) {
        //                 //
        //                 $private_candidate_query->select("id", "full_name_with_title", "exam_private_candidate_number");
        //             }])
        //             ->with(['cash_account' => function (Builder $cash_account_query) {
        //                 //
        //                 $cash_account_query->select("id", "name");
        //             }])
        //             ->with(['bank_account' => function (Builder $bank_account_query) {
        //                 //
        //                 $bank_account_query->select("id", "name");
        //             }])
        //             ->with(['receipt_voucher_status_type' => function (Builder $receipt_voucher_status_type_query) {
        //                 //
        //                 $receipt_voucher_status_type_query->select("id", "name");
        //             }])

        //             ->with(['receipt_voucher_attachment_list' => function (Builder $receipt_voucher_attachment_list_query) {
        //                 //
        //                 $receipt_voucher_attachment_list_query->select("id", "receipt_voucher_id", "file_name", "original_file_name", "mime_type");
        //             }])->select("*");
        //     }])
        //     ->with(['latest_term_fee_receipt_voucher' => function (Builder $latest_term_fee_receipt_voucher_query) {
        //         //
        //         return $latest_term_fee_receipt_voucher_query->select("*");
        //     }])
        //    ->with(['student_sport_list' => function (Builder $sport_list_query) {
        //         //
        //         $sport_list_query->select("student_id", "sport_id")
        //             ->with(['sport' => function (Builder $sport_query) {
        //                 //
        //                 $sport_query->select("id", "name", "sport_code");
        //             }]);
        //     }])
        //     ->with(['student_role_list' => function (Builder $student_role_list_query) {
        //         //
        //         $student_role_list_query->select("id", "student_id", "role_type_id", "academic_year", "assigned_date", "relieved_date", "remarks", "is_active")->where('is_active', true);
        //     }])
            // ->with(['grade_level_educator_role_list' => function (Builder $grade_level_educator_role_list_query) { $grade_level_educator_role_list_query->select("id", "educator_id", "grade_level_id",  "is_active","user_id")->where('is_active', true)->with(['user' => function (Builder $user_query) {
            //             $user_query->select("id", "call_name_with_title"  );
            //         }]);
            // }])
            // ->with(['student_attendance_list' => function (Builder $student_attendance_list_query) {
            //     $student_attendance_list_query
            //         ->select("id", "date", "attendance_type_id", "student_id") // include foreign key
            //         ->whereDate('date', now()) // only compare date part
            //         ->orderBy("id", "desc");
            // }])

            ->select(
                'id',
                'full_name',
                'student_calling_name',
                'gender',
                'date_of_birth',
                'admission_number',
                'joined_date',
                'full_name_with_title',
                'grade_level_id',
                'school_house_id',
                'student_admission_source_id',
                'student_admission_source_other',
                'admission_fee_discount_percentage',
                'approved_admission_fee',
                'applicable_refundable_deposit',
                'applicable_term_payment',
                'applicable_year_payment',
                'is_sport_list',
                //
                // "father_full_name",
                // "father_id_type",
                // "father_nic_number",
                // "father_passport_number",
                // "father_phone",
                // "father_whatsapp",
                // "father_email",
                // "father_occupation",
                // "father_place_of_work",
                // "father_monthly_income",
                // //
                // "mother_full_name",
                // "mother_id_type",
                // "mother_nic_number",
                // "mother_passport_number",
                // "mother_phone",
                // "mother_whatsapp",
                // "mother_email",
                // "mother_occupation",
                // "mother_place_of_work",
                // "mother_monthly_income",
                // //
                // "guardian_full_name",
                // "guardian_id_type",
                // "guardian_nic_number",
                // "guardian_passport_number",
                // "guardian_phone",
                // "guardian_whatsapp",
                // "guardian_email",
                // "guardian_occupation",
                // "guardian_place_of_work",
                // "guardian_monthly_income",
                //
                'student_phone',
                'student_email',
                'student_address',
                'school_studied_before',
                'blood_group',
                'special_health_conditions',
                'student_calling_name',
            )
            ->where('has_dropped_out',false)
            ->where('is_school_leaver',false)
            ->orderBy('admission_number_digits', 'desc')
            ->paginate(
                $perPage = $getStudentListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentListDataUserDTO['page']
            );

        return $studentListData;
    }
}
