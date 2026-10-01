<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a transient_token_hash column to payment_gateway_orders.
 *
 * Why a hash column instead of indexing transient_token directly:
 *   - transient_token is a TEXT column (UC result JWTs are 500-2000 chars)
 *   - MySQL/MariaDB cannot add a unique index directly on a TEXT column
 *   - A SHA-256 hex hash (64 chars) fits in a VARCHAR and is indexable
 *   - SHA-256 is collision-resistant for this use case (payment dedup)
 *
 * The unique constraint enforces at the database level that the same UC
 * result JWT cannot be used to create more than one ReceiptVoucher, even
 * if application-level checks are bypassed by a race condition or bug.
 *
 * The hash is nullable to allow rows created before this migration to
 * exist without the column — they will have NULL and will not trigger
 * the unique constraint (MySQL allows multiple NULLs in a unique index).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_gateway_orders', function (Blueprint $table) {
            // SHA-256 hex digest of transient_token — 64 hex chars, always fixed length
            $table->string('transient_token_hash', 64)
                ->nullable()
                ->unique()   // DB-level duplicate prevention
                ->after('transient_token')
                ->comment('SHA-256(transient_token) — unique constraint prevents duplicate ReceiptVouchers');
        });

        // Backfill existing rows that already have a transient_token stored.
        // Uses PHP hash() instead of DB-specific SHA2() for database portability.
        DB::table('payment_gateway_orders')
            ->whereNotNull('transient_token')
            ->whereNull('transient_token_hash')
            ->orderBy('id')
            ->chunk(100, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('payment_gateway_orders')
                        ->where('id', $row->id)
                        ->update([
                            'transient_token_hash' => hash('sha256', $row->transient_token),
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('payment_gateway_orders', function (Blueprint $table) {
            $table->dropUnique(['transient_token_hash']);
            $table->dropColumn('transient_token_hash');
        });
    }
};
