<?php

namespace Modules\AccountManagement\Intents\ReceivableDashboard\GetReceivableDashboardListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\TermFeePayment;
use Modules\SystemEntityManagement\Models\Term;

class GetReceivableDashboardListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getReceivableDashboardListDataUserDTO = GetReceivableDashboardListDataUserDTO::validate($payloadArray);

        // Action
        // addmission_fee_invoice start Data
        //
        $admission_fee_invoice_data['admission_fee_invoice_count'] = AdmissionFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->count();
        //
        $admission_fee_invoice_data['payment_completed_invoices_count'] = AdmissionFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_admission_fee_invoice_complete', true)
            ->whereNot('bill_total', 0)->count();
        //
        $admission_fee_invoice_data['due_payment_invoices_count'] = AdmissionFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_admission_fee_invoice_complete', false)
            ->whereNot('bill_total', 0)
            ->count();
        //
        $admission_fee_invoice_data['free_admission_invoices_count'] = AdmissionFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')->where('bill_total', 0)->count();
        //
        $admission_fee_invoice_data['payment_due_invoice_total_amount'] =
            AdmissionFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '<=', $value);
                        }
                    }
                }
            })->where('bill_total', '>', 0)->where('is_admission_fee_invoice_complete', false)->sum('bill_total')
            -
            ReceiptVoucher::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '<=', $value);
                        }
                    }
                }
            })->where('is_active', true)->where('student_id', '!=', null)->whereHas('admission_fee_invoice', function ($admission_fee_invoice_query) {
                $admission_fee_invoice_query->where(function (Builder $admission_fee_invoice_group1) {
                    $admission_fee_invoice_group1->where('is_admission_fee_invoice_complete', false);
                    $admission_fee_invoice_group1->whereNot('bill_total', 0);
                });
            })->sum('admission_fee_settlement');
        //
        $admission_fee_invoice_data['invoice_total_amount'] = AdmissionFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->sum('bill_total');
        // addmission_fee_invoice Data end

        // Refundable Deposit invoice Data start
        //
        $refundable_deposit_data['refundable_deposit_count'] = RefundableDeposit::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->count();

        //
        $refundable_deposit_data['due_payment_invoices_count'] = RefundableDeposit::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_refundable_deposit_complete', false)
            ->where('is_refund', false)
            ->whereNot('bill_total', 0)->count();

        //
        $refundable_deposit_data['invoice_total_amount'] = RefundableDeposit::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->sum('bill_total');
        //
        $refundable_deposit_data['payment_due_invoice_total_amount'] =
            RefundableDeposit::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '<=', $value);
                        }
                    }
                }
            })->where('bill_total', '>', 0)
                ->where('is_refund', false)
                ->where('is_refundable_deposit_complete', false)
                ->sum('bill_total')
            - ReceiptVoucher::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '<=', $value);
                        }
                    }
                }
            })->where('is_active', true)
                ->whereNotNull('student_id')
                ->whereHas('refundable_deposit', function (Builder $refundable_deposit_query) {
                    $refundable_deposit_query->where('is_refundable_deposit_complete', false);
                    $refundable_deposit_query->where('is_refund', false);
                })
                ->sum('refundable_deposit_settlement');
        //
        // Refundable Deposit Data End

        //
        //Term Fee Invoice Data start
        $term_fee_invoice_data['term_fee_invoice_count'] = TermFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->count();

        //
        $term_fee_invoice_data['due_payment_invoices_count'] = TermFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_term_fee_invoice_complete', false)
            ->whereNot('bill_total', 0)->count();

        //
        $term_fee_invoice_data['payment_due_invoice_total_amount'] =
            TermFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '<=', $value);
                        }
                    }
                }
            })->where('bill_total', '>', 0)->where('is_term_fee_invoice_complete', false)->sum('bill_total')
            -
            TermFeePayment::where('term_fee_invoice_id', '!=', null)->whereHas('term_fee_invoice', function ($term_fee_invoice_query) {
                $term_fee_invoice_query->where('is_term_fee_invoice_complete', false);
            })->sum('paid_amount');
        //
        $term_fee_invoice_data['invoice_total_amount'] = TermFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->sum('bill_total');
        // Term Fee Invoice Data End

        // Sport Fee Invoice Data Start
        $sport_fee_invoice_data['sport_fee_invoice_count'] = SportFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->count();
        //
        $sport_fee_invoice_data['due_payment_invoices_count'] = SportFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_sport_fee_invoice_complete', false)
            ->whereNot('bill_total', 0)->count();
        //
        $sport_fee_invoice_data['payment_due_invoice_total_amount'] =
            SportFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '<=', $value);
                        }
                    }
                }
            })->where('bill_total', '>', 0)->sum('bill_total') -
            ReceiptVoucher::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '<=', $value);
                        }
                    }
                }
            })->where('is_active', true)->sum('sport_fee');
        //
        $sport_fee_invoice_data['invoice_total_amount'] = SportFeeInvoice::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->sum('bill_total');
        //Term Fee Invoice Data End

        //Material Fee Invoice Data Start
        $material_invoice_data['material_bill_count'] = MaterialBill::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->count();
        //
        $material_invoice_data['due_payment_invoices_count'] = MaterialBill::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_material_bill_complete', false)
            // ->whereNot('bill_total', 0)
            ->count();
        //
        $material_invoice_data['payment_due_invoice_total_amount'] =
            MaterialBill::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('date', '<=', $value);
                        }
                    }
                }
            })->where('bill_total', '>', 0)->where('is_material_bill_complete', false)->sum('bill_total')
            -
            ReceiptVoucher::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $admission_fee_invoice_group1->where('payment_received_date', '<=', $value);
                        }
                    }
                }
            })->where('is_active', true)->where('student_id', '!=', null)->whereHas('material_bill', function ($material_bill_query) {
                $material_bill_query->where(function (Builder $material_bill_group1) {
                    $material_bill_group1->where('is_material_bill_complete', false);
                    // $material_bill_group1->whereNot('bill_total', 0);
                });
            })->sum('amount');
        //
        $material_invoice_data['invoice_total_amount'] = MaterialBill::where(function (Builder $admission_fee_invoice_group1) use ($getReceivableDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getReceivableDashboardListDataUserDTO) && ! is_null($getReceivableDashboardListDataUserDTO['search_filter_list']) && count($getReceivableDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceivableDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $admission_fee_invoice_group1->where('date', '<=', $value);
                    }
                }
            }
        })->sum('bill_total');
        //

        $dashboardData = [
            'data' => [
                'admission_fee_invoice_data' => $admission_fee_invoice_data,
                'refundable_deposit_data' => $refundable_deposit_data,
                'term_fee_invoice_data' => $term_fee_invoice_data,
                'sport_fee_invoice_data' => $sport_fee_invoice_data,
                'material_invoice_data' => $material_invoice_data,
            ],
        ];

        return $dashboardData;
    }
}
