<?php

namespace Modules\AccountManagement\Intents\PaymentDashboard\GetPaymentDashboardListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class GetPaymentDashboardListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getPaymentDashboardListDataUserDTO = GetPaymentDashboardListDataUserDTO::validate($payloadArray);

        // Action
        // addmission_fee_invoice start Data
        //
        $purchase_order_data['purchase_order_count'] = PurchaseOrder::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->count();
        //
        $purchase_order_data['payment_completed_invoices_count'] = AdmissionFeeInvoice::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_purchase_order_complete', true)
            ->whereNot('bill_total', 0)->count();
        //
        $purchase_order_data['due_payment_invoices_count'] = AdmissionFeeInvoice::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_purchase_order_complete', false)
            ->whereNot('bill_total', 0)
            ->count();
        //
        $purchase_order_data['free_admission_invoices_count'] = AdmissionFeeInvoice::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')->where('bill_total', 0)->count();
        //
        $purchase_order_data['payment_due_invoice_total_amount'] =
            AdmissionFeeInvoice::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $purchase_order_group1->where('date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $purchase_order_group1->where('date', '<=', $value);
                        }
                    }
                }
            })->where('bill_total', '>', 0)->where('is_purchase_order_complete', false)->sum('bill_total')
            -
            ReceiptVoucher::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $purchase_order_group1->where('payment_received_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $purchase_order_group1->where('payment_received_date', '<=', $value);
                        }
                    }
                }
            })->where('is_active', true)->where('student_id', '!=', null)->whereHas('purchase_order', function ($purchase_order_query) {
                $purchase_order_query->where(function (Builder $purchase_order_group1) {
                    $purchase_order_group1->where('is_purchase_order_complete', false);
                    $purchase_order_group1->whereNot('bill_total', 0);
                });
            })->sum('admission_fee_settlement');
        //
        $purchase_order_data['invoice_total_amount'] = AdmissionFeeInvoice::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->sum('bill_total');
        // addmission_fee_invoice Data end

        // Refundable Deposit invoice Data start
        //
        $refundable_deposit_data['refundable_deposit_count'] = RefundableDeposit::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->count();

        //
        $refundable_deposit_data['due_payment_invoices_count'] = RefundableDeposit::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->select('id')
            ->where('is_refundable_deposit_complete', false)
            ->where('is_refund', false)
            ->whereNot('bill_total', 0)->count();

        //
        $refundable_deposit_data['invoice_total_amount'] = RefundableDeposit::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $purchase_order_group1->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $purchase_order_group1->where('date', '<=', $value);
                    }
                }
            }
        })->sum('bill_total');
        //
        $refundable_deposit_data['payment_due_invoice_total_amount'] =
            RefundableDeposit::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $purchase_order_group1->where('date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $purchase_order_group1->where('date', '<=', $value);
                        }
                    }
                }
            })->where('bill_total', '>', 0)
                ->where('is_refund', false)
                ->where('is_refundable_deposit_complete', false)
                ->sum('bill_total')
            - ReceiptVoucher::where(function (Builder $purchase_order_group1) use ($getPaymentDashboardListDataUserDTO) {
                // Handle group_filter
                if (array_key_exists('search_filter_list', $getPaymentDashboardListDataUserDTO) && ! is_null($getPaymentDashboardListDataUserDTO['search_filter_list']) && count($getPaymentDashboardListDataUserDTO['search_filter_list']) > 0) {
                    foreach ($getPaymentDashboardListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $purchase_order_group1->where('payment_received_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $purchase_order_group1->where('payment_received_date', '<=', $value);
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

        $dashboardData = [
            'data' => [
                'purchase_order_data' => $purchase_order_data,
                'refundable_deposit_data' => $refundable_deposit_data,
            ],
        ];

        return $dashboardData;
    }
}
