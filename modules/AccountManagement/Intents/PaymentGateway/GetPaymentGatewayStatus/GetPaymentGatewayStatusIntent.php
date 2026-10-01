<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\GetPaymentGatewayStatus;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentGatewaySetting;

/**
 * Lets the frontend check whether the payment gateway is enabled BEFORE the
 * payer fills in an amount, so "Under Maintenance" can show immediately on
 * opening the pay flow. This is a UX convenience only — the real enforcement
 * is the same check repeated inside InitiatePaymentSessionIntent, since this
 * flag could flip between this call and the actual payment attempt.
 */
class GetPaymentGatewayStatusIntent
{
    use AsAction;

    private const GATEWAY_NAME = 'hnb_cybersource';

    public function handle(): array
    {
        $setting = PaymentGatewaySetting::where('gateway_name', self::GATEWAY_NAME)->first();

        // Fail closed: if the row is missing for some reason, treat the gateway
        // as unavailable rather than silently allowing payments through.
        $isActive = $setting?->is_active ?? false;

        return [
            'is_active'           => $isActive,
            'maintenance_message' => $isActive
                ? null
                : ($setting?->maintenance_message ?? 'Online payments are temporarily unavailable. Please try again later.'),
        ];
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle();

            return response()->json([
                'status'   => 'successful',
                'message'  => '',
                'data'     => $result,
                'metadata' => null,
            ], 200);
        } catch (\Exception $e) {
            Log::error('GetPaymentGatewayStatus: error', [
                'message' => $e->getMessage(),
                'user_id' => $request->user()?->id,
            ]);

            // Fail closed here too — an error checking status should not be
            // interpreted by the frontend as "gateway is available".
            return response()->json([
                'status'   => 'successful',
                'message'  => '',
                'data'     => [
                    'is_active'           => false,
                    'maintenance_message' => 'Online payments are temporarily unavailable. Please try again later.',
                ],
                'metadata' => null,
            ], 200);
        }
    }
}
