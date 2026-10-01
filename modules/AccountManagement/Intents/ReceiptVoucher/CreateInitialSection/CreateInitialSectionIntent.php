<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\CreateInitialSection;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateInitialSectionIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $createInitialSectionUserDTO = CreateInitialSectionUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $actionData['username'] = $request->user()->username;
            $actionData['receipt_voucher_unsaved_attachment_list'] = $request->receipt_voucher_unsaved_attachment_list;
            $receiptVoucher = CreateInitialSectionAction::run($createInitialSectionUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $receiptVoucher;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        // return response()->json(
        //     [
        //         "status" => "failed",
        //         "message" => "",
        //         "data" => $request->all(),
        //         "metadata" => null,
        //     ],
        //     500
        // );
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
