<?php

namespace Modules\AccountManagement\Intents\MaterialBill\GetMaterialBillListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\MaterialBill;

class GetMaterialBillListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // MaterialBill Data Validation
        $getMaterialBillListDataUserDTO = GetMaterialBillListDataUserDTO::validate($payloadArray);

        // Action
        $material_bill = MaterialBill::where(function (Builder $material_bill_group1) use ($getMaterialBillListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('group_filter', $getMaterialBillListDataUserDTO) && $getMaterialBillListDataUserDTO['group_filter'] != '') {
                if ($getMaterialBillListDataUserDTO['group_filter'] == 'All') {
                    // $material_bill_group1->where('is_active', true);
                } elseif ($getMaterialBillListDataUserDTO['group_filter'] == 'Payment Completed Invoices') {
                    $material_bill_group1->where('is_material_bill_complete', true);
                    // $material_bill_group1->whereNot('bill_total', 0);
                } elseif ($getMaterialBillListDataUserDTO['group_filter'] == 'Payment Due Invoices') {
                    $material_bill_group1->where('is_material_bill_complete', false);
                    // $material_bill_group1->whereNot('bill_total', 0);
                }
            }
        })->where(function (Builder $material_bill_group2) use ($getMaterialBillListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getMaterialBillListDataUserDTO['search_filter_list'])) {
                foreach ($getMaterialBillListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $material_bill_group3) use ($getMaterialBillListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getMaterialBillListDataUserDTO) && $getMaterialBillListDataUserDTO['search_phrase'] != '') {

                $material_bill_group3->where('serial_number', 'ILIKE', '%'.$getMaterialBillListDataUserDTO['search_phrase'].'%');

                $material_bill_group3->orWhereHas('student', function (Builder $student_query) use ($getMaterialBillListDataUserDTO) {
                    return $student_query->where('full_name', 'ILIKE', '%'.$getMaterialBillListDataUserDTO['search_phrase'].'%');
                });

                $material_bill_group3->orWhereHas('material_bill_item_list', function (Builder $material_bill_item_list_query) use ($getMaterialBillListDataUserDTO) {
                    return $material_bill_item_list_query->where('print_description', 'ILIKE', '%'.$getMaterialBillListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where('student_id', $getMaterialBillListDataUserDTO['student_id'])
            //
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->select('*');
            }])
            ->with(['applicant' => function (Builder $applicant_query) {
                //
                $applicant_query->select('*');
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
            ->with(['material_bill_item_list' => function (Builder $material_bill_item_list_query) {
                //
                $material_bill_item_list_query->with(['material_item' => function (Builder $material_item_query) {
                    //
                    $material_item_query->with(['material_item_type' => function (Builder $material_item_type_query) {
                        //
                        $material_item_type_query->select('*');
                    }])->with(['material_item_category' => function (Builder $material_item_category_query) {
                        //
                        $material_item_category_query->select('*');
                    }])->with(['unit' => function (Builder $unit_query) {
                        //
                        $unit_query->select('*');
                    }])->select('*');
                }])->select(
                    'id',
                    'material_bill_id',
                    'material_item_id',
                    'item_quantity',
                    'print_description',
                    'print_quantity',
                    'print_unit',
                    'ordered_quantity',
                    'billed_quantity',
                    'issued_quantity',
                    'unit_price',
                    'item_total',
                );
            }])
            ->select(
                'id',
                'date',
                'student_id',
                'applicant_id',
                'invoice_party',
                'items_total',
                'service_charges_total',
                'subtotal_before_discount',
                'discount_total',
                'subtotal_after_discount',
                'tax_total',
                'bill_total',
                'order_notes',
                'office_notes',
                'serial_number'
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getMaterialBillListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMaterialBillListDataUserDTO['page']
            );

        return $material_bill;
    }
}
