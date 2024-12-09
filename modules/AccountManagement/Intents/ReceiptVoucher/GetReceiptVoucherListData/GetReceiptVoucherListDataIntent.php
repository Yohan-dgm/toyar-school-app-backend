<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\GetReceiptVoucherListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Models\ReceiptVoucherStatusType;

class GetReceiptVoucherListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getReceiptVoucherListDataUserDTO = GetReceiptVoucherListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $receiptVoucherListData = GetReceiptVoucherListDataAction::run($getReceiptVoucherListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data["receipt_voucher_count"] = DB::table("receipt_voucher")->count();

            // Action 3
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data["receipt_voucher_status_type_count"] = ReceiptVoucherStatusType::select("id", "name")->withCount(['receipt_voucher_list' => function (Builder $receipt_voucher_status_type_query) {}])->orderBy("sequential_order", "asc")->get();

            // After Intent

            // Return Response
            return array_merge($receiptVoucherListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            // Get Intent Result
            $result = $this->handle($request);
            // Response Data Validation
            $getReceiptVoucherListDataResDTO = GetReceiptVoucherListDataResDTO::validate($result);
            // Send Response
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $getReceiptVoucherListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
