<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\GetMyPaymentHistory;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentGatewayOrder;

class GetMyPaymentHistoryIntent
{
    use AsAction;

    public function handle(Request $request): array
    {
        $user = $request->user();
        $page = max(1, (int) $request->input('page', 1));

        $paginator = PaymentGatewayOrder::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $page);

        $payments = collect($paginator->items())->map(function (PaymentGatewayOrder $order) {
            return [
                'id'                    => $order->id,
                'order_reference'       => $order->order_reference,
                'invoice_type'          => $order->invoice_type,
                'invoice_id'            => $order->invoice_id,
                'amount'                => (float) $order->amount,
                'currency'              => $order->currency,
                'service_fee_amount'    => (float) $order->service_fee_amount,
                'total_charged_amount'  => (float) $order->total_charged_amount,
                'admin_status'          => $order->admin_status,
                'admin_notes'           => $order->admin_notes,
                'admin_approved_at'     => $order->admin_approved_at?->toIso8601String(),
                'cybersource_reference' => $order->cybersource_reference,
                'receipt_voucher_id'    => $order->receipt_voucher_id,
                'created_at'            => $order->created_at,
            ];
        })->values()->all();

        Log::info('GetMyPaymentHistory: fetched', [
            'user_id'      => $user->id,
            'page'         => $page,
            'total'        => $paginator->total(),
            'record_count' => count($payments),
        ]);

        return [
            'payments'   => $payments,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
                'has_more'     => $paginator->hasMorePages(),
            ],
        ];
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);

            return response()->json([
                'status'   => 'successful',
                'message'  => '',
                'data'     => $result,
                'metadata' => null,
            ], 200);

        } catch (\Exception $e) {
            Log::error('GetMyPaymentHistory: error', [
                'message' => $e->getMessage(),
                'user_id' => $request->user()?->id,
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => 'Unable to load payment history.',
                'error'   => 'PAYMENT_HISTORY_ERROR',
            ], 422);
        }
    }
}
