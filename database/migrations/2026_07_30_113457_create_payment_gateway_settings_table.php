<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * DB-driven on/off switch for online payment gateways. When is_active is
 * false, payers see "Under Maintenance" instead of the payment flow —
 * enforced both in the UI (GetPaymentGatewayStatusIntent) and, as the real
 * gate, inside InitiatePaymentSessionIntent itself.
 *
 * Seeds one active row for the current gateway so this migration doesn't
 * change existing behavior on its own — nothing goes down until someone
 * explicitly flips is_active to false.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_name')->unique(); // e.g. "hnb_cybersource"
            $table->boolean('is_active')->default(true);
            $table->string('maintenance_message')->nullable();
            $table->timestamps();
        });

        DB::table('payment_gateway_settings')->insert([
            'gateway_name'         => 'hnb_cybersource',
            'is_active'            => true,
            'maintenance_message'  => null,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_settings');
    }
};
