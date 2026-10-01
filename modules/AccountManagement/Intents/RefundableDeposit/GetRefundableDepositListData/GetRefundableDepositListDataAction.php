<?php

namespace Modules\AccountManagement\Intents\RefundableDeposit\GetRefundableDepositListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\RefundableDeposit;

class GetRefundableDepositListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // RefundableDeposit Data Validation
        $getRefundableDepositListDataUserDTO = GetRefundableDepositListDataUserDTO::validate($payloadArray);

        // Action
        $refundable_deposit = RefundableDeposit::where(function (Builder $refundable_deposit_group1) use ($getRefundableDepositListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('group_filter', $getRefundableDepositListDataUserDTO) && $getRefundableDepositListDataUserDTO['group_filter'] != '') {
                if ($getRefundableDepositListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getRefundableDepositListDataUserDTO['group_filter'] == 'Payment Completed Invoices') {
                    $refundable_deposit_group1->where('is_refundable_deposit_complete', true);
                    $refundable_deposit_group1->whereNot('bill_total', 0);
                } elseif ($getRefundableDepositListDataUserDTO['group_filter'] == 'Payment Due Invoices') {
                    $refundable_deposit_group1->where('is_refundable_deposit_complete', false);
                    $refundable_deposit_group1->whereNot('bill_total', 0)
                        ->where('is_refund', false);
                } elseif ($getRefundableDepositListDataUserDTO['group_filter'] == 'Free Refundable Invoices') {
                    $refundable_deposit_group1->where('bill_total', 0);
                } elseif ($getRefundableDepositListDataUserDTO['group_filter'] == 'Refund Invoices') {
                    $refundable_deposit_group1->where('is_refund', true);
                }
            }
        })->where(function (Builder $refundable_deposit_group2) use ($getRefundableDepositListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getRefundableDepositListDataUserDTO['search_filter_list'])) {
                foreach ($getRefundableDepositListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $refundable_deposit_group3) use ($getRefundableDepositListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getRefundableDepositListDataUserDTO) && $getRefundableDepositListDataUserDTO['search_phrase'] != '') {

                $refundable_deposit_group3->where('serial_number', 'ILIKE', '%'.$getRefundableDepositListDataUserDTO['search_phrase'].'%');

                $refundable_deposit_group3->orWhereHas('student', function (Builder $student_query) use ($getRefundableDepositListDataUserDTO) {
                    return $student_query->where('full_name', 'ILIKE', '%'.$getRefundableDepositListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getRefundableDepositListDataUserDTO['search_phrase'].'%');
                });

                $refundable_deposit_group3->orWhereHas('refundable_deposit_item_list', function (Builder $refundable_deposit_item_list_query) use ($getRefundableDepositListDataUserDTO) {
                    return $refundable_deposit_item_list_query->where('description', 'ILIKE', '%'.$getRefundableDepositListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where('student_id', $getRefundableDepositListDataUserDTO['student_id'])
            //
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->with(['grade_level' => function (Builder $grade_level_query) {
                    //
                    $grade_level_query->with(['school_fee_list' => function (Builder $school_fee_list_query) {
                        //
                        $school_fee_list_query->select('id', 'school_fee_type', 'grade_level_id', 'amount', 'is_active');
                    }]);
                    $grade_level_query->select('id', 'name');
                }])->select('*');
            }])
            ->with(['receipt_voucher_list' => function (Builder $receipt_voucher_list_query) {
                //
                $receipt_voucher_list_query->where('is_active', true);
                $receipt_voucher_list_query->with(['student' => function (Builder $student_query) {
                    //
                    $student_query->select('id', 'full_name_with_title', 'admission_number');
                }])
                    ->with(['applicant' => function (Builder $applicant_query) {
                        //
                        $applicant_query->select('id', 'full_name_with_title', 'applicant_number');
                    }])
                    ->with(['exam_private_candidate' => function (Builder $exam_private_candidate_query) {
                        //
                        $exam_private_candidate_query->select('id', 'full_name_with_title', 'exam_private_candidate_number');
                    }])
                    ->with(['private_candidate' => function (Builder $private_candidate_query) {
                        //
                        $private_candidate_query->select('id', 'full_name_with_title', 'exam_private_candidate_number');
                    }])
                    ->with(['cash_account' => function (Builder $cash_account_query) {
                        //
                        $cash_account_query->select('id', 'name');
                    }])
                    ->with(['bank_account' => function (Builder $bank_account_query) {
                        //
                        $bank_account_query->select('id', 'name');
                    }])
                    ->with(['receipt_voucher_status_type' => function (Builder $receipt_voucher_status_type_query) {
                        //
                        $receipt_voucher_status_type_query->select('id', 'name');
                    }])
                    ->with(['receipt_voucher_attachment_list' => function (Builder $receipt_voucher_attachment_list_query) {
                        //
                        $receipt_voucher_attachment_list_query->select('*');
                    }])->select('*');
            }])
            ->with(['refundable_deposit_item_list' => function (Builder $refundable_deposit_item_list_query) {
                //
                $refundable_deposit_item_list_query->select(
                    'id',
                    'refundable_deposit_id',
                    'school_fee_id',
                    'description',
                    'is_refundable_deposit_item_complete',
                    'item_total',
                );
            }])
            ->select(
                'id',
                'date',
                'student_id',
                'items_total',
                'service_charges_total',
                'subtotal_before_discount',
                'discount_total',
                'subtotal_after_discount',
                // 'tax_total',
                'bill_total',
                'order_notes',
                'office_notes',
                'serial_number'
            )
            ->orderBy('serial_number_digits', 'desc')
            ->paginate(
                $perPage = $getRefundableDepositListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getRefundableDepositListDataUserDTO['page']
            );

        return $refundable_deposit;
    }
}
