<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Postgres implements Laravel's enum() as an anonymous CHECK
        // constraint - look up whatever it was actually named instead of
        // assuming the default naming convention, so this is safe even if
        // the constraint name differs across environments.
        $constraint = DB::selectOne("
            SELECT conname FROM pg_constraint
            WHERE conrelid = 'canteen_order'::regclass
              AND contype = 'c'
              AND pg_get_constraintdef(oid) LIKE '%status%'
        ");
        if ($constraint) {
            DB::statement('ALTER TABLE canteen_order DROP CONSTRAINT '.$constraint->conname);
        }
        DB::statement("ALTER TABLE canteen_order ADD CONSTRAINT canteen_order_status_check CHECK (status IN ('Pending', 'Completed', 'Cancelled'))");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE canteen_order DROP CONSTRAINT IF EXISTS canteen_order_status_check');
        DB::statement("ALTER TABLE canteen_order ADD CONSTRAINT canteen_order_status_check CHECK (status IN ('Pending', 'Cancelled'))");
    }
};
