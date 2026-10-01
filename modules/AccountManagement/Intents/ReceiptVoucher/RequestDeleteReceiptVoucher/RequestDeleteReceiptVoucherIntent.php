<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\RequestDeleteReceiptVoucher;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestDeleteReceiptVoucherIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $requestDeleteReceiptVoucherUserDTO = RequestDeleteReceiptVoucherUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            // $actionData['receipt_voucher_delete_unsaved_attachment_list'] = $request->receipt_voucher_delete_unsaved_attachment_list;
            $event = RequestDeleteReceiptVoucherAction::run($requestDeleteReceiptVoucherUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $event;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => '',
                        'data' => $result,
                        'metadata' => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => '',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
