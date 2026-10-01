<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Adds 'gateway_timeout' to the allowed payment_gateway_orders.status values.
 *
 * CompletePaymentIntent sets status to 'gateway_timeout' when the CyberSource
 * authorization call times out — the charge outcome is unknown pending manual
 * reconciliation against the CyberSource dashboard. That is a distinct case
 * from 'failed' (a confirmed decline), but the original status CHECK
 * constraint only allowed pending/completed/failed/expired, so that update
 * was violating the constraint in production.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE payment_gateway_orders DROP CONSTRAINT IF EXISTS payment_gateway_orders_status_check');
        DB::statement("ALTER TABLE payment_gateway_orders ADD CONSTRAINT payment_gateway_orders_status_check CHECK (status IN ('pending', 'completed', 'failed', 'expired', 'gateway_timeout'))");
    }

    public function down(): void
    {
        // Reconcile any gateway_timeout rows before restoring the narrower
        // constraint, otherwise the ADD CONSTRAINT below would fail on existing data.
        DB::table('payment_gateway_orders')
            ->where('status', 'gateway_timeout')
            ->update(['status' => 'failed']);

        DB::statement('ALTER TABLE payment_gateway_orders DROP CONSTRAINT IF EXISTS payment_gateway_orders_status_check');
        DB::statement("ALTER TABLE payment_gateway_orders ADD CONSTRAINT payment_gateway_orders_status_check CHECK (status IN ('pending', 'completed', 'failed', 'expired'))");
    }
};
