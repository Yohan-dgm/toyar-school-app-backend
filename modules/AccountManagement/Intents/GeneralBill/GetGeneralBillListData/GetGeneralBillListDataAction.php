<?php

namespace Modules\AccountManagement\Intents\GeneralBill\GetGeneralBillListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\GeneralBill;

class GetGeneralBillListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // GeneralBill Data Validation
        $getGeneralBillListDataUserDTO = GetGeneralBillListDataUserDTO::validate($payloadArray);

        // Action
        $general_billListData = GeneralBill::where(function (Builder $general_bill_query_group1) use ($getGeneralBillListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getGeneralBillListDataUserDTO) && $getGeneralBillListDataUserDTO['group_filter'] != '') {
                if ($getGeneralBillListDataUserDTO['group_filter'] == 'All') {
                    $general_bill_query_group1->where('has_dropped_out', false);
                } elseif ($getGeneralBillListDataUserDTO['group_filter'] == 'School Leavers') {
                    $general_bill_query_group1->where('has_dropped_out', true);
                } elseif ($getGeneralBillListDataUserDTO['group_filter'] == 'Incomplete') {
                    $general_bill_query_group1->whereNull('father_full_name')
                        ->whereNull('mother_full_name')
                        ->whereNull('guardian_full_name');
                } elseif ($getGeneralBillListDataUserDTO['group_filter'] == 'Calypso' || $getGeneralBillListDataUserDTO['group_filter'] == 'Eurus' || $getGeneralBillListDataUserDTO['group_filter'] == 'Tellus' || $getGeneralBillListDataUserDTO['group_filter'] == 'Vulcan') {
                    $general_bill_query_group1->where('has_dropped_out', false)->whereHas('school_house', function (Builder $school_house_query) use ($getGeneralBillListDataUserDTO) {
                        return $school_house_query->where('name', '=', $getGeneralBillListDataUserDTO['group_filter']);
                    });
                } else {
                    $general_bill_query_group1->where('has_dropped_out', false)->whereHas('grade_level', function (Builder $grade_level_query) use ($getGeneralBillListDataUserDTO) {
                        return $grade_level_query->where('name', '=', $getGeneralBillListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $general_bill_query_group2) use ($getGeneralBillListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getGeneralBillListDataUserDTO) && ! is_null($getGeneralBillListDataUserDTO['search_filter_list']) && count($getGeneralBillListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getGeneralBillListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $general_bill_query_group3) use ($getGeneralBillListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getGeneralBillListDataUserDTO) && $getGeneralBillListDataUserDTO['search_phrase'] != '') {
                $general_bill_query_group3->where('full_name', 'ILIKE', '%'.$getGeneralBillListDataUserDTO['search_phrase'].'%');
                $general_bill_query_group3->orWhere('admission_number', 'ILIKE', '%'.$getGeneralBillListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['grade_level' => function (Builder $grade_level_query) {
                //
                $grade_level_query->select('id', 'name');
            }])
            ->with(['school_house' => function (Builder $school_house_query) {
                //
                $school_house_query->select('id', 'name');
            }])
            ->with(['general_bill_admission_source' => function (Builder $general_bill_admission_source_query) {
                //
                $general_bill_admission_source_query->select('id', 'name');
            }])
            ->with(['general_bill_attachment_list' => function (Builder $general_bill_attachment_list_query) {
                //
                $general_bill_attachment_list_query->select('id', 'general_bill_id', 'file_name', 'original_file_name', 'mime_type');
            }])
            ->with(['receipt_voucher_list' => function (Builder $receipt_voucher_list_query) {
                //
                $receipt_voucher_list_query->select('id', 'general_bill_id', 'admission_fee_settlement', 'refundable_deposit_settlement', 'term_fee_settlement');
            }])
            ->select(
                'id',
                'full_name',
                'gender',
                'date_of_birth',
                'admission_number',
                'joined_date',
                'full_name_with_title',
                'grade_level_id',
                'school_house_id',
                'general_bill_admission_source_id',
                'general_bill_admission_source_other',
                'admission_fee_discount_percentage',
                'approved_admission_fee',
                'applicable_refundable_deposit',
                'applicable_term_payment',
                'applicable_year_payment',
                //
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
                //
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
                //
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
                //
                'general_bill_phone',
                'general_bill_email',
                'general_bill_address',
                'school_studied_before',
                'blood_group',
                'special_health_conditions',
            )
            ->orderBy('admission_number_digits', 'desc')
            ->paginate(
                $perPage = $getGeneralBillListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getGeneralBillListDataUserDTO['page']
            );

        return $general_billListData;
    }
}
