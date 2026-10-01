<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\InitiatePaymentSession;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentGatewayOrder;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\PaymentGatewaySetting;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\UserPaymentStudent;

class InitiatePaymentSessionIntent
{
    use AsAction;

    private const GATEWAY_NAME = 'hnb_cybersource';

    public function handle(Request $request): array
    {
        // 0. Maintenance gate — the real enforcement point (GetPaymentGatewayStatusIntent
        //    is only a UX convenience so the frontend can show this before the payer
        //    fills in an amount; this check is what actually stops a charge from
        //    happening while the gateway is flagged off).
        $gatewaySetting = PaymentGatewaySetting::where('gateway_name', self::GATEWAY_NAME)->first();
        if (!$gatewaySetting || !$gatewaySetting->is_active) {
            abort(503, $gatewaySetting?->maintenance_message ?? 'Online payments are temporarily unavailable. Please try again later.');
        }

        // 1. Validate user input
        $dto = InitiatePaymentSessionUserDTO::validate($request->all());

        // 2. Security: verify the student exists and belongs to the requesting
        //    user (prevents an authenticated user from paying against — or
        //    balance-probing — another family's student/invoice).
        //
        //    Only UserPaymentStudent.is_active is checked here — that's the
        //    literal "is this student link active" flag and it's the same
        //    condition GetStudentListByUserAction uses to decide which students
        //    (and therefore which pending invoices) show up in the app for this
        //    user. Extra conditions (has_dropped_out/is_school_leaver on Student,
        //    or UserPayment.is_active on the parent's package) are deliberately
        //    NOT checked here — GetStudentListByUserAction doesn't check them
        //    either, so requiring them here caused real payments to be wrongly
        //    rejected with "Invalid student." for students the app was actively
        //    showing as payable.
        $user = $request->user();

        $student = Student::where('id', $dto['student_id'])->first();

        $isOwnedByUser = $student && UserPaymentStudent::where('student_id', $dto['student_id'])
            ->where('is_active', true)
            ->whereHas('user_payment', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->exists();

        if (!$student || !$isOwnedByUser) {
            abort(403, 'Invalid student.');
        }

        // 3. Security: verify the invoice belongs to that student and the amount is valid
        $balanceAmount = $this->getInvoiceBalance($dto['invoice_type'], $dto['invoice_id'], $dto['student_id']);
        if ($balanceAmount === null) {
            abort(404, 'Invoice not found for this student.');
        }
        if ((float) $dto['amount'] > (float) $balanceAmount + 0.01) {
            abort(422, 'Payment amount exceeds invoice balance.');
        }
        if ((float) $dto['amount'] < 1) {
            abort(422, 'Payment amount must be at least LKR 1.00.');
        }

        // 4. Compute the online payment service charge (surcharge). Applied on
        //    top of the invoice-facing amount — does NOT change what the
        //    ReceiptVoucher records or what the invoice balance is validated
        //    against above. Stored per-order (not just read from config later)
        //    so a future rate change doesn't reinterpret historical orders.
        $feePercentage      = (float) config('services.cybersource.service_fee_percentage', 3);
        $serviceFeeAmount   = round((float) $dto['amount'] * $feePercentage / 100, 2);
        $totalChargedAmount = round((float) $dto['amount'] + $serviceFeeAmount, 2);

        // 5. Generate idempotency key (also used as CyberSource v-c-request-id)
        $orderReference = Str::uuid()->toString();

        // 6. Expire any old pending orders for this same invoice (cleanup)
        PaymentGatewayOrder::where('user_id', $user->id)
            ->where('invoice_type', $dto['invoice_type'])
            ->where('invoice_id', $dto['invoice_id'])
            ->where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        $actionData = [
            'user_id'              => $user->id,
            'order_reference'      => $orderReference,
            'service_fee_percentage' => $feePercentage,
            'service_fee_amount'     => $serviceFeeAmount,
            'total_charged_amount'   => $totalChargedAmount,
        ];

        // 7. Call CyberSource session API
        $result = InitiatePaymentSessionAction::run($dto, $actionData);

        return $result;
    }

    /**
     * Look up the actual balance for the invoice.
     * Returns null if the invoice doesn't belong to the given student.
     */
    private function getInvoiceBalance(string $invoiceType, int $invoiceId, int $studentId): ?float
    {
        switch ($invoiceType) {
            case 'Term Fee':
                $invoice = TermFeeInvoice::where('id', $invoiceId)
                    ->where('student_id', $studentId)
                    ->with(['term_fee_payment_list' => fn($q) => $q->where('is_active', true)])
                    ->first();
                if (!$invoice) return null;
                $paid = $invoice->term_fee_payment_list->sum('paid_amount');
                return max(0, $invoice->bill_total - $paid);

            case 'Admission Fee':
                $invoice = AdmissionFeeInvoice::where('id', $invoiceId)
                    ->where('student_id', $studentId)
                    ->with(['receipt_voucher_list' => fn($q) => $q->where('is_active', true)])
                    ->first();
                if (!$invoice) return null;
                $paid = $invoice->receipt_voucher_list->sum('amount');
                return max(0, $invoice->bill_total - $paid);

            case 'Sport Fee':
                $invoice = SportFeeInvoice::where('id', $invoiceId)
                    ->where('student_id', $studentId)
                    ->with(['receipt_voucher_list' => fn($q) => $q->where('is_active', true)])
                    ->first();
                if (!$invoice) return null;
                $paid = $invoice->receipt_voucher_list->sum('amount');
                return max(0, $invoice->bill_total - $paid);

            case 'Exam Bill':
                $bill = ExamBill::where('id', $invoiceId)
                    ->where('student_id', $studentId)
                    ->with(['exam_bill_payment_list' => fn($q) => $q->where('is_active', true)])
                    ->first();
                if (!$bill) return null;
                $paid = $bill->exam_bill_payment_list->sum('paid_amount');
                return max(0, $bill->total - $paid);

            case 'Material Bill':
                $bill = MaterialBill::where('id', $invoiceId)
                    ->where('student_id', $studentId)
                    ->with(['receipt_voucher_list' => fn($q) => $q->where('is_active', true)])
                    ->first();
                if (!$bill) return null;
                $paid = $bill->receipt_voucher_list->sum('amount');
                return max(0, $bill->bill_total - $paid);

            default:
                return null;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            $resDTO = InitiatePaymentSessionResDTO::validate($result);

            return response()->json([
                'status'   => 'successful',
                'message'  => '',
                'data'     => $resDTO,
                'metadata' => null,
            ], 200);
        } catch (\Exception $e) {
            // Log EVERY payment exception with full context for debugging
            \Illuminate\Support\Facades\Log::error('Payment Session Error: ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'file'            => $e->getFile() . ':' . $e->getLine(),
                'trace_snippet'   => array_slice(explode("\n", $e->getTraceAsString()), 0, 5),
            ]);

            // The maintenance-gate abort(503, ...) — the only 503 HttpException this
            // Intent throws — is tagged with a distinguishable error code so the
            // frontend can show the same "Under Maintenance" UI it shows from
            // GetPaymentGatewayStatusIntent, instead of a generic payment-failed alert.
            // Other abort()s (403/404/422 — invalid student, invoice not found, amount
            // validation) deliberately fall through to the generic response below,
            // unchanged from prior behavior.
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $e->getStatusCode() === 503) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => $e->getMessage(),
                    'error'   => 'GATEWAY_UNDER_MAINTENANCE',
                ], 503);
            }

            if ($e->getMessage() === 'GATEWAY_TIMEOUT') {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'The payment server took too long to respond. Your account has not been charged. Please try again.',
                    'error'   => 'GATEWAY_TIMEOUT',
                ], 503); // 503 Service Unavailable — gateway is down, not our fault
            }

            // IMPORTANT: Do NOT return 502 here.
            // Cloudflare intercepts any 502 response from the origin and replaces it with
            // its own error page, so the app never receives the JSON body.
            // 422 passes through Cloudflare cleanly and correctly signals a payment error.
            //
            // Do NOT include $e->getMessage() in the client-facing response — it can
            // contain the raw CyberSource error response body. Full detail is already
            // logged above; the client only needs a generic, actionable message.
            return response()->json([
                'status'  => 'failed',
                'message' => 'We could not start your payment session. Your account has not been charged. Please try again.',
                'error'   => 'PAYMENT_SESSION_ERROR',
            ], 422);
        }
    }
}
