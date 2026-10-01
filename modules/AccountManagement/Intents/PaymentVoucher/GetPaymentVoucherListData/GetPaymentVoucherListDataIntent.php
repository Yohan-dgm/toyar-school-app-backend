<?php

namespace Modules\AccountManagement\Intents\PaymentVoucher\GetPaymentVoucherListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPaymentVoucherListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // PaymentVoucher Data Validation
            $getPaymentVoucherListDataUserDTO = GetPaymentVoucherListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $paymentVoucherListData = GetPaymentVoucherListDataAction::run($getPaymentVoucherListDataUserDTO, $actionData);
            $data['payment_voucher_count'] = DB::table('payment_voucher')->count();
            // After Intent

            // Return Response
            return array_merge($paymentVoucherListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetPaymentVoucherListDataResDTO = GetPaymentVoucherListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetPaymentVoucherListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
