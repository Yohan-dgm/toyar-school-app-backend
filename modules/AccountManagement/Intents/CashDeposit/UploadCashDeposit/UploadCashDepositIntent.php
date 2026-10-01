<?php

namespace Modules\AccountManagement\Intents\CashDeposit\UploadCashDeposit;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class UploadCashDepositIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $uploadCashDepositUserDTO = UploadCashDepositUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $actionData['username'] = $request->user()->username;
            $actionData['cash_deposit_slip_unsaved_attachment_list'] = $request->cash_deposit_slip_unsaved_attachment_list;
            $actionData['cash_deposit_slip_attachment_list'] = $request->cash_deposit_slip_attachment_list;
            $cashDeposit = UploadCashDepositAction::run($uploadCashDepositUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $cashDeposit;
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
