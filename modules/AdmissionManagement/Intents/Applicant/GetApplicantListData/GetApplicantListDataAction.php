<?php

namespace Modules\AdmissionManagement\Intents\Applicant\GetApplicantListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AdmissionManagement\Models\Applicant;

class GetApplicantListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Applicant Data Validation
        $getApplicantListDataUserDTO = GetApplicantListDataUserDTO::validate($payloadArray);

        // Action
        $applicantListData = Applicant::where(function (Builder $applicant_query_group1) use ($getApplicantListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getApplicantListDataUserDTO) && $getApplicantListDataUserDTO['group_filter'] != '') {
                if ($getApplicantListDataUserDTO['group_filter'] == 'Waiting List') {
                    return $applicant_query_group1->where('has_converted_to_student', '=', false);
                } elseif ($getApplicantListDataUserDTO['group_filter'] == 'Converted List') {
                    return $applicant_query_group1->where('has_converted_to_student', '=', true);
                } else {
                    // $applicant_query_group1->whereHas('grade_level', function (Builder $grade_level_query) use ($getApplicantListDataUserDTO) {
                    //     return $grade_level_query->where('name', '=', $getApplicantListDataUserDTO['group_filter']);
                    // });
                }
            }
        })->where(function (Builder $applicant_query_group2) use ($getApplicantListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getApplicantListDataUserDTO) && ! is_null($getApplicantListDataUserDTO['search_filter_list']) && count($getApplicantListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getApplicantListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($value != null) {
                        $applicant_query_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $applicant_query_group3) use ($getApplicantListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getApplicantListDataUserDTO) && $getApplicantListDataUserDTO['search_phrase'] != '') {
                $applicant_query_group3->where('full_name', 'ILIKE', '%'.$getApplicantListDataUserDTO['search_phrase'].'%');
                $applicant_query_group3->orWhere('applicant_number', 'ILIKE', '%'.$getApplicantListDataUserDTO['search_phrase'].'%');
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
            ->with(['term' => function (Builder $term_query) {
                //
                $term_query->select('id', 'name');
            }])
            ->select(
                'id',
                'full_name',
                'gender',
                'date_of_birth',
                'applicant_number',
                'full_name_with_title',
                'grade_level_id',
                'approved_admission_fee',
                'approved_refundable_deposit',
                'approved_term_payment',
                'has_converted_to_student',
                'start_term_id'
            )
            ->orderBy('applicant_number_digits', 'desc')
            ->paginate(
                $perPage = $getApplicantListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getApplicantListDataUserDTO['page']
            );

        return $applicantListData;
    }
}
