<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\GetPurchaseOrderListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class GetPurchaseOrderListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // PurchaseOrder Data Validation
        $getPurchaseOrderListDataUserDTO = GetPurchaseOrderListDataUserDTO::validate($payloadArray);

        // Action
        $purchase_order = PurchaseOrder::where(function (Builder $purchase_order_group1) use ($getPurchaseOrderListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('group_filter', $getPurchaseOrderListDataUserDTO) && $getPurchaseOrderListDataUserDTO['group_filter'] != '') {
                if ($getPurchaseOrderListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getPurchaseOrderListDataUserDTO['group_filter'] == 'Payment Completed Order') {
                    $purchase_order_group1->where('is_purchase_order_complete', true);
                } elseif ($getPurchaseOrderListDataUserDTO['group_filter'] == 'Payment Due Order') {
                    $purchase_order_group1->where('is_purchase_order_complete', false);
                }
            }
        })->where(function (Builder $purchase_order_group2) use ($getPurchaseOrderListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getPurchaseOrderListDataUserDTO['search_filter_list'])) {
                foreach ($getPurchaseOrderListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $purchase_order_group3) use ($getPurchaseOrderListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getPurchaseOrderListDataUserDTO) && $getPurchaseOrderListDataUserDTO['search_phrase'] != '') {

                $purchase_order_group3->where('serial_number', 'ILIKE', '%'.$getPurchaseOrderListDataUserDTO['search_phrase'].'%');

                $purchase_order_group3->orWhere('general_supplier_info', 'ILIKE', '%'.$getPurchaseOrderListDataUserDTO['search_phrase'].'%');

                $purchase_order_group3->orWhereHas('supplier', function (Builder $supplier_query) use ($getPurchaseOrderListDataUserDTO) {
                    return $supplier_query->where('name', 'ILIKE', '%'.$getPurchaseOrderListDataUserDTO['search_phrase'].'%');
                });

                $purchase_order_group3->orWhereHas('purchase_order_item_list', function (Builder $purchase_order_item_list_query) use ($getPurchaseOrderListDataUserDTO) {
                    return $purchase_order_item_list_query->where('print_description', 'ILIKE', '%'.$getPurchaseOrderListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['supplier' => function (Builder $supplier_query) {
                //
                $supplier_query->select('*');
            }])
            ->with(['goods_received_note_list' => function (Builder $goods_received_note_list_query) {
                //
                $goods_received_note_list_query->with(['goods_received_note_item_list' => function (Builder $goods_received_note_item_list_query) {
                    //
                    $goods_received_note_item_list_query->with(['purchase_order_item' => function (Builder $purchase_order_item_query) {
                        //
                        $purchase_order_item_query->with(['material_item' => function (Builder $material_item_query) {
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
                        }])->select('*');
                    }])->with(['received_by' => function (Builder $received_by_query) {
                        //
                        $received_by_query->select('*');
                    }])->select('*');
                }])->with(['goods_received_note_attachment_list' => function (Builder $goods_received_note_attachment_list_query) {
                    //
                    $goods_received_note_attachment_list_query->select('id', 'goods_received_note_id', 'file_name', 'original_file_name', 'mime_type');
                }])->with(['purchase_order' => function (Builder $purchase_order_query) {
                    //
                    $purchase_order_query->select('*');
                }])->select('*');
            }])
            ->with(['services_received_note_list' => function (Builder $services_received_note_list_query) {
                //
                $services_received_note_list_query->with(['services_received_note_item_list' => function (Builder $services_received_note_item_list_query) {
                    //
                    $services_received_note_item_list_query->with(['purchase_order_item' => function (Builder $purchase_order_item_query) {
                        //
                        $purchase_order_item_query->with(['material_item' => function (Builder $material_item_query) {
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
                        }])->select('*');
                    }])->with(['received_by' => function (Builder $received_by_query) {
                        //
                        $received_by_query->select('*');
                    }])->select('*');
                }])->with(['services_received_note_attachment_list' => function (Builder $services_received_note_attachment_list_query) {
                    //
                    $services_received_note_attachment_list_query->select('id', 'services_received_note_id', 'file_name', 'original_file_name', 'mime_type');
                }])->with(['purchase_order' => function (Builder $purchase_order_query) {
                    //
                    $purchase_order_query->select('*');
                }])->select('*');
            }])
            ->with(['supplier_bill_list' => function (Builder $supplier_bill_list_query) {
                //
                $supplier_bill_list_query->with(['supplier_bill_item_list' => function (Builder $supplier_bill_item_list_query) {
                    //
                    $supplier_bill_item_list_query->with(['purchase_order_item' => function (Builder $purchase_order_item_query) {
                        //
                        $purchase_order_item_query->with(['material_item' => function (Builder $material_item_query) {
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
                        }])->select('*');
                    }])->select('*');
                }])->with(['supplier_bill_attachment_list' => function (Builder $supplier_bill_attachment_list_query) {
                    //
                    $supplier_bill_attachment_list_query->select('id', 'supplier_bill_id', 'file_name', 'original_file_name', 'mime_type');
                }])->with(['purchase_order' => function (Builder $purchase_order_query) {
                    //
                    $purchase_order_query->select('*');
                }])->select('*');
            }])
            ->with(['payment_voucher_list' => function (Builder $payment_voucher_list_query) {
                //
                $payment_voucher_list_query->with(['cash_account' => function (Builder $cash_account_query) {
                    //
                    $cash_account_query->select('*');
                }])->with(['bank_account' => function (Builder $bank_account_query) {
                    //
                    $bank_account_query->select('*');
                }])->with(['check_bank_account' => function (Builder $check_bank_account_query) {
                    //
                    $check_bank_account_query->select('*');
                }])->with(['payment_issued_by' => function (Builder $payment_issued_by_query) {
                    //
                    $payment_issued_by_query->select('*');
                }])->with(['purchase_order' => function (Builder $purchase_order_query) {
                    //
                    $purchase_order_query->select('*');
                }])->with(['expense_note' => function (Builder $expense_note_query) {
                    //
                    $expense_note_query->select('*');
                }])->select('*');
            }])
            ->with(['purchase_order_item_list' => function (Builder $purchase_order_item_list_query) {
                //
                $purchase_order_item_list_query->with(['material_item' => function (Builder $material_item_query) {
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
                    'purchase_order_id',
                    'item_type',
                    'material_item_id',
                    'item_quantity',
                    'print_description',
                    'print_quantity',
                    'print_unit',
                    'ordered_quantity',
                    'billed_quantity',
                    'received_quantity',
                );
            }])
            ->select(
                'id',
                'date',
                'supplier_id',
                'general_supplier_info',
                'order_notes',
                'office_notes',
                'serial_number'
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getPurchaseOrderListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getPurchaseOrderListDataUserDTO['page']
            );

        return $purchase_order;
    }
}
