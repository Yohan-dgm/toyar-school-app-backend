<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\RequestDeleteReceiptVoucher;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\ReceiptVoucherDeleteAttachment;
use Modules\AccountManagement\Models\RequestDeleteReceiptVoucher;

class RequestDeleteReceiptVoucherAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $requestDeleteReceiptVoucherUserDTO = RequestDeleteReceiptVoucherUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['requested_by'] = $actionData['created_by'];
        $system_data['requested_date'] = date('Y-m-d'.' '.'H:i:s');
        $system_data['receipt_voucher_id'] = $requestDeleteReceiptVoucherUserDTO['id'];

        if ($requestDeleteReceiptVoucherUserDTO['delete_reason'] === 'Other') {
            $requestDeleteReceiptVoucherUserDTO['delete_reason'] = $requestDeleteReceiptVoucherUserDTO['name'];
        }
        // System Data Validation
        $requestDeleteReceiptVoucherSystemDTO = RequestDeleteReceiptVoucherSystemDTO::validate($system_data);
        // Final Data Validation

        $requestDeleteReceiptVoucherDTO = RequestDeleteReceiptVoucherDTO::validate(array_merge($requestDeleteReceiptVoucherUserDTO, $requestDeleteReceiptVoucherSystemDTO));

        // Save In Database
        ReceiptVoucher::where('id', $requestDeleteReceiptVoucherDTO['id'])->update(['is_deleted_reqested' => 1]);

        // Create Unsaved Attachments
        // $receiptVoucher = ReceiptVoucher::find($requestDeleteReceiptVoucherDTO['id']);
        // if (!is_null($actionData['receipt_voucher_delete_unsaved_attachment_list']) && count($actionData['receipt_voucher_delete_unsaved_attachment_list']) > 0) {
        //     foreach ($actionData['receipt_voucher_delete_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
        //         $path = "attachments/account-management/receipt-voucher-delete/$receiptVoucher->serial_number_digits/";
        //         $data = [];
        //         $data['receipt_voucher_id'] = $receiptVoucher->id;
        //         $data['extension'] = !is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
        //         $data['file_name'] = $this->getUniqueFileName($receiptVoucher->serial_number_digits, $path, $data['extension']);
        //         $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
        //         $data['mime_type'] = $unsaved_attachment->getClientMimeType();
        //         $data['created_by'] = $actionData['user_id'];
        //         $receiptVoucherAttachment = ReceiptVoucherDeleteAttachment::create($data);
        //         $pathWithFileNameAndExtension = "attachments/account-management/receipt-voucher-delete/$receiptVoucher->serial_number_digits/" . $data['file_name'];
        //         Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
        //     }
        // }

        $voucherId = $requestDeleteReceiptVoucherDTO['id'];
        unset($requestDeleteReceiptVoucherDTO['name']);
        unset($requestDeleteReceiptVoucherDTO['id']);
        $requestDeleteReceiptVoucher = RequestDeleteReceiptVoucher::create($requestDeleteReceiptVoucherDTO);

        $updateDate['request_delete_receipt_voucher_id'] = $requestDeleteReceiptVoucher->id;
        ReceiptVoucher::where('id', $voucherId)->update($updateDate);

        return $requestDeleteReceiptVoucher;
    }
    // function getUniqueFileName($prefix, $path, $extension)
    // {
    //     $count = 1;
    //     $file = "";
    //     if (is_null($extension)) {
    //         $extension = "";
    //     }
    //     do {
    //         if ($count == 1) {
    //             $file =  $prefix . '-' . microtime(true) . '.' . $extension;
    //             $count++;
    //         } else {
    //             $file =  $prefix . '-' . microtime(true) . '_' . $count . '.' . $extension;
    //             $count++;
    //         }
    //     } while (file_exists($path . $file));
    //     return $file;
    // }
}
