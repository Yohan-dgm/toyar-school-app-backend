<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\GetPaymentReceipt;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentGatewayOrder;

/**
 * Returns receipt data for a completed online payment — used by the app to
 * render a downloadable PDF receipt on-device.
 *
 * This is the real verification point: a receipt is only ever returned for
 * an order that (a) belongs to the requesting user and (b) actually has
 * status = 'completed'. A pending/failed/expired order — or one belonging to
 * someone else — gets a 404, regardless of what the client claims.
 *
 * Reads only payment_gateway_orders (+ the student relation, for the name on
 * the receipt) — deliberately does not touch ReceiptVoucher or any other
 * Account Management table. The receipt number is derived from the order's
 * own id, not a ReceiptVoucher record.
 */
class GetPaymentReceiptDataIntent
{
    use AsAction;

    public function handle(Request $request): array
    {
        $orderReference = (string) $request->input('order_reference', '');
        $user = $request->user();

        $order = PaymentGatewayOrder::where('order_reference', $orderReference)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('student')
            ->first();

        if (!$order) {
            abort(404, 'Receipt not available.');
        }

        $receiptNumber = "PGO-{$order->id}";

        $studentName = $order->student?->full_name_with_title
            ?? $order->student?->full_name
            ?? 'Student';

        return [
            'order_reference'       => $order->order_reference,
            'receipt_number'        => $receiptNumber,
            'school_name'           => 'Nexis College',
            'student_name'          => $studentName,
            'invoice_type'          => $order->invoice_type,
            'invoice_id'            => $order->invoice_id,
            'amount'                => (float) $order->amount,
            'service_fee_amount'    => (float) $order->service_fee_amount,
            'total_charged_amount'  => (float) $order->total_charged_amount,
            'currency'              => $order->currency,
            'payment_date'          => ($order->admin_approved_at ?? $order->created_at)?->toIso8601String(),
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
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
                'error'   => 'RECEIPT_NOT_AVAILABLE',
            ], $e->getStatusCode());
        } catch (\Exception $e) {
            Log::error('GetPaymentReceiptData: error', [
                'message' => $e->getMessage(),
                'user_id' => $request->user()?->id,
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => 'Unable to load receipt.',
                'error'   => 'RECEIPT_ERROR',
            ], 422);
        }
    }
}
