<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentDetailsByClass;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;

class GetStudentDetailsByClassAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Student Data Validation
        $getStudentDetailsByClassUserDTO = GetStudentDetailsByClassUserDTO::validate($payloadArray);

        // Action
        $studentListData = Student::where('grade_level_class_id', $getStudentDetailsByClassUserDTO['grade_level_class_id'])
            ->where('has_dropped_out', false)
            ->where('is_school_leaver', false)
            ->where(function (Builder $student_query_group3) use ($getStudentDetailsByClassUserDTO) {
                // search_phrase within the class
                if (array_key_exists('search_phrase', $getStudentDetailsByClassUserDTO) && $getStudentDetailsByClassUserDTO['search_phrase'] != '') {
                    $student_query_group3->where('full_name', 'ILIKE', '%'.$getStudentDetailsByClassUserDTO['search_phrase'].'%');
                    $student_query_group3->orWhere('admission_number', 'ILIKE', '%'.$getStudentDetailsByClassUserDTO['search_phrase'].'%');
                }
            })
            ->with(['grade_level' => function (Builder $grade_level_query) {
                $grade_level_query->with(['school_fee_list' => function (Builder $school_fee_list_query) {
                    $school_fee_list_query->select('id', 'school_fee_type', 'grade_level_id', 'amount', 'is_active');
                }]);
                $grade_level_query->select('id', 'name');
            }])
            ->with(['grade_level_class' => function (Builder $grade_level_class_query) {
                $grade_level_class_query->select('id', 'name', 'grade_level_id');
            }])
            ->with(['school_house' => function (Builder $school_house_query) {
                $school_house_query->select('id', 'name');
            }])
            ->with(['student_attachment_list' => function (Builder $student_attachment_list_query) {
                $student_attachment_list_query->select('id', 'student_id', 'file_name', 'original_file_name', 'mime_type');
            }])
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
                'grade_level_class_id',
                'school_house_id',
                'student_admission_source_id',
                'student_admission_source_other',
                'admission_fee_discount_percentage',
                'approved_admission_fee',
                'applicable_refundable_deposit',
                'applicable_term_payment',
                'applicable_year_payment',
                'is_sport_list',
                'father_full_name',
                'father_id_type',
                'father_nic_number',
                'father_passport_number',
                'father_phone',
                'father_whatsapp',
                'father_email',
                'father_occupation',
                'father_place_of_work',
                'father_monthly_income',
                'mother_full_name',
                'mother_id_type',
                'mother_nic_number',
                'mother_passport_number',
                'mother_phone',
                'mother_whatsapp',
                'mother_email',
                'mother_occupation',
                'mother_place_of_work',
                'mother_monthly_income',
                'guardian_full_name',
                'guardian_id_type',
                'guardian_nic_number',
                'guardian_passport_number',
                'guardian_phone',
                'guardian_whatsapp',
                'guardian_email',
                'guardian_occupation',
                'guardian_place_of_work',
                'guardian_monthly_income',
                'student_phone',
                'student_email',
                'student_address',
                'school_studied_before',
                'blood_group',
                'special_health_conditions',
                'nationality_id',
                'religion_id',
                'full_address',
                'phone',
                'email',
                'special_conditions'
            )  
            ->orderBy('admission_number_digits', 'asc')
            ->paginate(
                $perPage = 100,
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentDetailsByClassUserDTO['page']
            );

        return $studentListData;
    }
}
