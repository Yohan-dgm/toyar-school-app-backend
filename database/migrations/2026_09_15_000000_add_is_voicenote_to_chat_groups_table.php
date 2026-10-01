<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_groups', function (Blueprint $table) {
            $table->boolean('is_voicenote')->default(true)->after('only_admins_can_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_groups', function (Blueprint $table) {
            $table->dropColumn('is_voicenote');
        });
    }
};
