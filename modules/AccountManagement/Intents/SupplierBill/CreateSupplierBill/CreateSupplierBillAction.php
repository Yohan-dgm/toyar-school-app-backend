<?php

namespace Modules\AccountManagement\Intents\SupplierBill\CreateSupplierBill;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Modules\AccountManagement\Intents\SupplierBillItem\CreateSupplierBillItem\CreateSupplierBillItemAction;
use Modules\AccountManagement\Intents\SupplierBillItem\CreateSupplierBillItem\CreateSupplierBillItemUserDTO;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\AccountManagement\Models\SupplierBill;
use Modules\AccountManagement\Models\SupplierBillAttachment;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class CreateSupplierBillAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createSupplierBillUserDTO = CreateSupplierBillUserDTO::validate($payloadArray);

        $createSupplierBillUserDTO['items_total'] = is_null($createSupplierBillUserDTO['items_total'] == 'null') || $createSupplierBillUserDTO['items_total'] == 'null' ? 0 : $createSupplierBillUserDTO['items_total'];
        $createSupplierBillUserDTO['transport_charges_total'] = is_null($createSupplierBillUserDTO['transport_charges_total'] == 'null') || $createSupplierBillUserDTO['transport_charges_total'] == 'null' ? 0 : $createSupplierBillUserDTO['transport_charges_total'];
        $createSupplierBillUserDTO['service_charges_total'] = is_null($createSupplierBillUserDTO['service_charges_total'] == 'null') || $createSupplierBillUserDTO['service_charges_total'] == 'null' ? 0 : $createSupplierBillUserDTO['service_charges_total'];
        $createSupplierBillUserDTO['subtotal_before_discount'] = is_null($createSupplierBillUserDTO['subtotal_before_discount'] == 'null') || $createSupplierBillUserDTO['subtotal_before_discount'] == 'null' ? 0 : $createSupplierBillUserDTO['subtotal_before_discount'];
        $createSupplierBillUserDTO['discount_total'] = is_null($createSupplierBillUserDTO['discount_total'] == 'null') || $createSupplierBillUserDTO['discount_total'] == 'null' ? 0 : $createSupplierBillUserDTO['discount_total'];
        $createSupplierBillUserDTO['subtotal_after_discount'] = is_null($createSupplierBillUserDTO['subtotal_after_discount'] == 'null') || $createSupplierBillUserDTO['subtotal_after_discount'] == 'null' ? 0 : $createSupplierBillUserDTO['subtotal_after_discount'];
        $createSupplierBillUserDTO['tax_total'] = is_null($createSupplierBillUserDTO['tax_total'] == 'null') || $createSupplierBillUserDTO['tax_total'] == 'null' ? 0 : $createSupplierBillUserDTO['tax_total'];
        $createSupplierBillUserDTO['bill_total'] = is_null($createSupplierBillUserDTO['bill_total'] == 'null') || $createSupplierBillUserDTO['bill_total'] == 'null' ? 0 : $createSupplierBillUserDTO['bill_total'];

        $createSupplierBillUserDTO['office_notes'] = is_null($createSupplierBillUserDTO['office_notes'] == 'null') || $createSupplierBillUserDTO['office_notes'] == 'null' ? null : $createSupplierBillUserDTO['office_notes'];

        $system_data['serial_number_prefix'] = 'NY/SUP-BILL';
        $maxDigits = SupplierBill::where(function (Builder $receipt_query) {
            $serial_number_financial_year = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
            $receipt_query->where('serial_number_financial_year', '=', $serial_number_financial_year);
        })->max('serial_number_digits');

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'].'/'.$system_data['serial_number_suffix'];
        }
        $system_data['created_by'] = $actionData['user_id'];

        $createSupplierBillSystemDTO = CreateSupplierBillSystemDTO::validate($system_data);
        $createSupplierBillDTO = CreateSupplierBillDTO::validate(array_merge($createSupplierBillUserDTO, $createSupplierBillSystemDTO));
        $createdSupplierBill = SupplierBill::create($createSupplierBillDTO);
        // Create Unsaved Attachments
        if (! is_null($actionData['supplier_bill_unsaved_attachment_list']) && count($actionData['supplier_bill_unsaved_attachment_list']) > 0) {
            foreach ($actionData['supplier_bill_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/account-management/supplier-bill/$createdSupplierBill->serial_number_digits/";
                $data = [];
                $data['supplier_bill_id'] = $createdSupplierBill->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($createdSupplierBill->serial_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $supplierBillAttachment = SupplierBillAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/account-management/supplier-bill/$createdSupplierBill->serial_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        // Bill Items
        $supplierBillItemList = $actionData['supplier_bill_item_list'] ?? [];
        foreach ($supplierBillItemList as $item) {
            $item = json_decode($item, true);
            $item['supplier_bill_id'] = $createdSupplierBill->id;
            $createSupplierBillItemUserDTO = CreateSupplierBillItemUserDTO::validate($item);
            $supplierBillItemActionData = [
                'purchase_order_id' => $createSupplierBillUserDTO['purchase_order_id'],
                'user_id' => $actionData['user_id'],
            ];
            CreateSupplierBillItemAction::run($createSupplierBillItemUserDTO, $supplierBillItemActionData);
        }

        $createdSupplierBill = SupplierBill::with(['supplier_bill_item_list' => function (Builder $supplier_bill_item_list_query) {
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
        }])->with(['purchase_order' => function (Builder $purchase_order_query) {
            //
            $purchase_order_query->with(['supplier' => function (Builder $supplier_query) {
                //
                $supplier_query->select('id', 'name', 'serial_number');
            }])->select('*');
        }])->select('*')->find($createdSupplierBill->id);

        if ($createSupplierBillUserDTO['purchase_order_id'] != null && $createSupplierBillUserDTO['purchase_order_id'] != 'null') {
            $paymentVoucherSum = PaymentVoucher::where('purchase_order_id', $createSupplierBillUserDTO['purchase_order_id'])->sum('amount');
            $purchaseOrderSum = SupplierBill::whereHas('purchase_order')->where('purchase_order_id', $createSupplierBillUserDTO['purchase_order_id'])->sum('bill_total');

            if ($paymentVoucherSum >= floatval($purchaseOrderSum)) {
                PurchaseOrder::where('id', $createSupplierBillUserDTO['purchase_order_id'])->update(['is_purchase_order_complete' => true]);
            } else {
                PurchaseOrder::where('id', $createSupplierBillUserDTO['purchase_order_id'])->update(['is_purchase_order_complete' => false]);
            }
        }

        return $createdSupplierBill;
    }

    public function getUniqueFileName($prefix, $path, $extension)
    {
        $count = 1;
        $file = '';
        if (is_null($extension)) {
            $extension = '';
        }
        do {
            if ($count == 1) {
                $file = $prefix.'-'.microtime(true).'.'.$extension;
                $count++;
            } else {
                $file = $prefix.'-'.microtime(true).'_'.$count.'.'.$extension;
                $count++;
            }
        } while (file_exists($path.$file));

        return $file;
    }
}
