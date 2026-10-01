<?php

namespace Modules\AccountManagement\Intents\StudentPendingInvoice\GetStudentPendingInvoiceListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetStudentPendingInvoiceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Student Pending Invoice Data Validation
            $getStudentPendingInvoiceListDataUserDTO = GetStudentPendingInvoiceListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $pendingInvoices = GetStudentPendingInvoiceListDataAction::run($getStudentPendingInvoiceListDataUserDTO, $actionData);

            // After Intent

            // Return Response
            return [
                'pending_invoices' => $pendingInvoices
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetStudentPendingInvoiceListDataResDTO = GetStudentPendingInvoiceListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetStudentPendingInvoiceListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            \Log::error('GetStudentPendingInvoiceListData ERROR', [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
                'trace'   => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
}
