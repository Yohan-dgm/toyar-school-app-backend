<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the online-payment service fee (surcharge) fields to payment_gateway_orders.
 *
 * `amount` keeps meaning "invoice-facing amount" as it already does — the fee
 * does NOT change what the ReceiptVoucher records or what the student's balance
 * is reduced by. `total_charged_amount` is the fee-inclusive figure actually
 * sent to CyberSource and charged to the card.
 *
 * `service_fee_percentage` is stored per-order (not just read from config at
 * display time) so that if the rate changes later, historical orders still
 * reflect the rate that was actually applied to them.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_gateway_orders', function (Blueprint $table) {
            $table->decimal('service_fee_percentage', 5, 2)->default(3.00)->after('currency');
            $table->decimal('service_fee_amount', 10, 2)->default(0)->after('service_fee_percentage');
            $table->decimal('total_charged_amount', 10, 2)->default(0)->after('service_fee_amount');
        });
    }

    public function down(): void
    {
        Schema::table('payment_gateway_orders', function (Blueprint $table) {
            $table->dropColumn(['service_fee_percentage', 'service_fee_amount', 'total_charged_amount']);
        });
    }
};

