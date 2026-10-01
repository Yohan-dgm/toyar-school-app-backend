<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\GetAdmissionFeeInvoiceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;

class GetAdmissionFeeInvoiceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // AdmissionFeeInvoice Data Validation
        $getAdmissionFeeInvoiceListDataUserDTO = GetAdmissionFeeInvoiceListDataUserDTO::validate($payloadArray);

        // Action
        $admission_fee_invoice = AdmissionFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getAdmissionFeeInvoiceListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('group_filter', $getAdmissionFeeInvoiceListDataUserDTO) && $getAdmissionFeeInvoiceListDataUserDTO['group_filter'] != '') {
                if ($getAdmissionFeeInvoiceListDataUserDTO['group_filter'] == 'All') {
                    // $admission_fee_invoice_group1->where('is_active', true);
                } elseif ($getAdmissionFeeInvoiceListDataUserDTO['group_filter'] == 'Payment Completed Invoices') {
                    $admission_fee_invoice_group1->where('is_admission_fee_invoice_complete', true);
                    $admission_fee_invoice_group1->whereNot('bill_total', 0);
                } elseif ($getAdmissionFeeInvoiceListDataUserDTO['group_filter'] == 'Payment Due Invoices') {
                    $admission_fee_invoice_group1->where('is_admission_fee_invoice_complete', false);
                    $admission_fee_invoice_group1->whereNot('bill_total', 0);
                } elseif ($getAdmissionFeeInvoiceListDataUserDTO['group_filter'] == 'Free Admission Invoices') {
                    $admission_fee_invoice_group1->where('bill_total', 0);
                }
            }
        })->where(function (Builder $admission_fee_invoice_group2) use ($getAdmissionFeeInvoiceListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getAdmissionFeeInvoiceListDataUserDTO['search_filter_list'])) {
                foreach ($getAdmissionFeeInvoiceListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $admission_fee_invoice_group3) use ($getAdmissionFeeInvoiceListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getAdmissionFeeInvoiceListDataUserDTO) && $getAdmissionFeeInvoiceListDataUserDTO['search_phrase'] != '') {

                $admission_fee_invoice_group3->where('serial_number', 'ILIKE', '%'.$getAdmissionFeeInvoiceListDataUserDTO['search_phrase'].'%');

                $admission_fee_invoice_group3->orWhereHas('applicant', function (Builder $applicant_query) use ($getAdmissionFeeInvoiceListDataUserDTO) {
                    return $applicant_query->where('full_name', 'ILIKE', '%'.$getAdmissionFeeInvoiceListDataUserDTO['search_phrase'].'%');
                });
                $admission_fee_invoice_group3->orWhereHas('student', function (Builder $student_query) use ($getAdmissionFeeInvoiceListDataUserDTO) {
                    return $student_query->where('full_name', 'ILIKE', '%'.$getAdmissionFeeInvoiceListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getAdmissionFeeInvoiceListDataUserDTO['search_phrase'].'%');
                });

                $admission_fee_invoice_group3->orWhereHas('admission_fee_invoice_item_list', function (Builder $admission_fee_invoice_item_list_query) use ($getAdmissionFeeInvoiceListDataUserDTO) {
                    return $admission_fee_invoice_item_list_query->where('description', 'ILIKE', '%'.$getAdmissionFeeInvoiceListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where('student_id', $getAdmissionFeeInvoiceListDataUserDTO['student_id'])
            //
            ->with(['applicant' => function (Builder $applicant_query) {
                //
                $applicant_query->with(['grade_level' => function (Builder $grade_level_query) {
                    //
                    $grade_level_query->with(['school_fee_list' => function (Builder $school_fee_list_query) {
                        //
                        $school_fee_list_query->select('id', 'school_fee_type', 'grade_level_id', 'amount', 'is_active');
                    }]);
                    $grade_level_query->select('id', 'name');
                }])->select('*');
            }])

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
                    ->with(['student' => function (Builder $student_query) {
                        //
                        $student_query->select('*');
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
            ->with(['admission_fee_invoice_item_list' => function (Builder $admission_fee_invoice_item_list_query) {
                //
                $admission_fee_invoice_item_list_query->select(
                    'id',
                    'admission_fee_invoice_id',
                    'school_fee_id',
                    'description',
                    'is_admission_fee_invoice_item_complete',
                    'item_total',
                );
            }])
            ->select(
                'id',
                'date',
                'student_id',
                'applicant_id',
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
                $perPage = $getAdmissionFeeInvoiceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getAdmissionFeeInvoiceListDataUserDTO['page']
            );

        return $admission_fee_invoice;
    }
}
