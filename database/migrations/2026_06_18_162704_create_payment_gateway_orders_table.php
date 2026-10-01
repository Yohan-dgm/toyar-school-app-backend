<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateway_orders', function (Blueprint $table) {
            $table->id();

            // Idempotency key — also used as v-c-request-id header to CyberSource
            $table->uuid('order_reference')->unique();

            // Who is paying
            $table->unsignedBigInteger('user_id'); // authenticated parent
            $table->unsignedBigInteger('student_id'); // student being paid for

            // What is being paid
            $table->string('invoice_type'); // "Term Fee", "Admission Fee", "Exam Bill", etc.
            $table->unsignedBigInteger('invoice_id'); // PK in the relevant invoice table

            // Amount
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('LKR');

            // Payment flow status
            $table->enum('status', ['pending', 'completed', 'failed', 'expired'])->default('pending');

            // Admin review status — admin can see all gateway payments and approve
            $table->enum('admin_status', ['pending_review', 'approved', 'rejected'])->default('pending_review');
            $table->unsignedBigInteger('admin_approved_by')->nullable(); // FK to user who approved
            $table->timestamp('admin_approved_at')->nullable();
            $table->text('admin_notes')->nullable();

            // CyberSource data
            $table->text('transient_token')->nullable(); // returned by SDK on success
            $table->string('cybersource_reference')->nullable(); // CyberSource transaction ID
            $table->string('cybersource_decision')->nullable(); // AUTHORIZED, DECLINED, etc.

            // Auto-created internal record
            $table->unsignedBigInteger('receipt_voucher_id')->nullable(); // FK to auto-created ReceiptVoucher

            // Security
            $table->timestamp('expires_at'); // 15 minutes from creation (matches CyberSource JWT)

            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('student_id');
            $table->index('status');
            $table->index('admin_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_orders');
    }
};
