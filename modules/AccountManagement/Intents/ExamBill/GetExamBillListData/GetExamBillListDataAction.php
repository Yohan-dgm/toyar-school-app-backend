<?php

namespace Modules\AccountManagement\Intents\ExamBill\GetExamBillListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExamBill;

class GetExamBillListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ExamBill Data Validation
        $getExamBillListDataUserDTO = GetExamBillListDataUserDTO::validate($payloadArray);

        // Action
        $exam_bill = ExamBill::where(function (Builder $exam_bill_group1) use ($getExamBillListDataUserDTO) {
            // Handle group_filter
            if (! empty($getExamBillListDataUserDTO['group_filter']) && $getExamBillListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $exam_bill_group2) use ($getExamBillListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getExamBillListDataUserDTO['search_filter_list'])) {
                foreach ($getExamBillListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_bill_group3) use ($getExamBillListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getExamBillListDataUserDTO) && $getExamBillListDataUserDTO['search_phrase'] != '') {

                $exam_bill_group3->orWhere('serial_number', 'ILIKE', '%'.$getExamBillListDataUserDTO['search_phrase'].'%');

                $exam_bill_group3->orWhereHas('student', function (Builder $student_query) use ($getExamBillListDataUserDTO) {
                    return $student_query->where('full_name', 'ILIKE', '%'.$getExamBillListDataUserDTO['search_phrase'].'%');
                });

                $exam_bill_group3->orWhereHas('exam_private_candidate', function (Builder $exam_private_candidate_query) use ($getExamBillListDataUserDTO) {
                    return $exam_private_candidate_query->where('full_name', 'ILIKE', '%'.$getExamBillListDataUserDTO['search_phrase'].'%');
                });

                $exam_bill_group3->orWhereHas('exam_bill_item_list', function (Builder $exam_bill_item_list_query) use ($getExamBillListDataUserDTO) {
                    return $exam_bill_item_list_query->whereHas('exam_subject_list', function (Builder $exam_subject_list_query) use ($getExamBillListDataUserDTO) {
                        return $exam_subject_list_query->where('name', 'ILIKE', '%'.$getExamBillListDataUserDTO['search_phrase'].'%');
                    });
                });
            }
        })->where('student_id', $getExamBillListDataUserDTO['student_id'])
            //
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->select('id', 'full_name_with_title', 'admission_number');
            }])
            ->with(['exam_private_candidate' => function (Builder $exam_private_candidate_query) {
                //
                $exam_private_candidate_query->select('id', 'full_name_with_title', 'exam_private_candidate_number');
            }])
            ->with(['exam_bill_item_list' => function (Builder $exam_bill_item_list_query) {
                //
                $exam_bill_item_list_query
                    ->with(['exam_subject_category' => function (Builder $exam_subject_category_query) {
                        //
                        $exam_subject_category_query->select('id', 'name');
                    }])
                    ->with(['exam_subject_list' => function (Builder $exam_subject_list_query) {
                        //
                        $exam_subject_list_query->select('exam_subject_id as id', 'name', 'exam_subject_code', 'exam_subject_components', 'exam_subject_option_code', 'exam_subject_fee', 'has_practical_component');
                    }])
                    ->select('id', 'exam_bill_id', 'exam_subject_category_id', 'subtotal', 'total');
            }])
            ->with(['receipt_voucher_list' => function (Builder $receipt_voucher_list_query) {
                //
                $receipt_voucher_list_query->select('id', 'exam_bill_id', 'serial_number', 'payment_received_date', 'amount')->with('receipt_voucher_attachment_list')->orderBy('payment_received_date', 'asc');
            }])
            ->with(['exam_service_charge_list' => function (Builder $exam_service_charge_list_query) {
                //
                $exam_service_charge_list_query->select('exam_bill_id as id', 'exam_bill_id', 'exam_service_charge_id', 'exam_service_charge_rate', 'name');
            }])
            ->select(
                'id',
                'date',
                'bill_party',
                'student_id',
                'exam_private_candidate_id',
                'additional_service_charge',
                'exam_subjects_total',
                'exam_service_charges_total',
                'subtotal',
                'exam_bill_discount',
                'total',
                'bill_notes',
                'office_notes',
                'serial_number'
            )
            ->orderBy('serial_number_digits', 'desc')
            ->paginate(
                $perPage = $getExamBillListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamBillListDataUserDTO['page']
            );

        return $exam_bill;
    }
}
