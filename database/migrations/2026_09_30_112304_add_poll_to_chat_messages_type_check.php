<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Widens chat_messages.type's CHECK constraint to allow 'poll', mirroring
// the exact drop-and-recreate idiom already used in this codebase for
// payment_gateway_orders_status_check (2026_08_05_120000). Purely additive:
// every currently-allowed value stays allowed, existing rows are untouched.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE chat_messages DROP CONSTRAINT IF EXISTS chat_messages_type_check');
        DB::statement("ALTER TABLE chat_messages ADD CONSTRAINT chat_messages_type_check CHECK (type IN ('text', 'image', 'file', 'system', 'poll'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reconcile any poll-type rows before restoring the narrower
        // constraint, otherwise the ADD CONSTRAINT below would fail.
        DB::table('chat_messages')
            ->where('type', 'poll')
            ->update(['type' => 'system']);

        DB::statement('ALTER TABLE chat_messages DROP CONSTRAINT IF EXISTS chat_messages_type_check');
        DB::statement("ALTER TABLE chat_messages ADD CONSTRAINT chat_messages_type_check CHECK (type IN ('text', 'image', 'file', 'system'))");
    }
};
