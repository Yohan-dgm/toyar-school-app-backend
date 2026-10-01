<?php

namespace Modules\AccountManagement\Intents\CashDeposit\UploadCashDeposit;

use Illuminate\Support\Facades\Storage;
use Modules\AccountManagement\Models\CashDeposit;
use Modules\AccountManagement\Models\CashDepositSlipAttachment;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UploadCashDepositAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $uploadCashDepositUserDTO = UploadCashDepositUserDTO::validate($payloadArray);
        //system data
        $system_data['created_by'] = $actionData['created_by'];

        $uploadCashDepositSystemDTO = UploadCashDepositSystemDTO::validate($system_data);
        // $uploadCashDepositDTO = UploadCashDepositDTO::validate(array_merge($uploadCashDepositUserDTO, $uploadCashDepositSystemDTO));

        // $uploadCashDeposit = CashDeposit::create($uploadCashDepositDTO);
        $cashDeposit = CashDeposit::find($uploadCashDepositUserDTO['id']);

        // Updade Saved Attachments
        if (is_null($actionData['cash_deposit_slip_attachment_list']) && count($cashDeposit->cash_deposit_slip_attachment_list) > 0) {
            $persistedAttachmentList = $cashDeposit->cash_deposit_slip_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = $persistedFileNameList;
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    CashDepositSlipAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/account-management/cash-deposit-slip/$cashDeposit->id/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }
        if (! is_null($actionData['cash_deposit_slip_attachment_list']) && count($actionData['cash_deposit_slip_attachment_list']) > 0 && count($cashDeposit->cash_deposit_slip_attachment_list) > 0) {
            $persistedAttachmentList = $cashDeposit->cash_deposit_slip_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = array_merge(array_diff($persistedFileNameList, $actionData['cash_deposit_slip_attachment_list']), array_diff($actionData['cash_deposit_slip_attachment_list'], $persistedFileNameList));
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    CashDepositSlipAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/account-management/cash-deposit-slip/$cashDeposit->id/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }

        // Create Unsaved Attachments
        if (! is_null($actionData['cash_deposit_slip_unsaved_attachment_list']) && count($actionData['cash_deposit_slip_unsaved_attachment_list']) > 0) {
            foreach ($actionData['cash_deposit_slip_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/account-management/cash-deposit-slip/$cashDeposit->id/";
                $data = [];
                $data['cash_deposit_id'] = $cashDeposit->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($cashDeposit->id, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['created_by'];
                $supplierBillAttachment = CashDepositSlipAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/account-management/cash-deposit-slip/$cashDeposit->id/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        $updateData['is_attached'] = true;
        $updateData['created_by'] = $actionData['created_by'];
        $cashDeposit->update($updateData);

        // create invoice log
        $logData['description'] = '[STATUS: Uploaded Cash Deposit Slip, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$cashDeposit->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Cash Deposit';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $cashDeposit;
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
