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
        Schema::create('chat_poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_poll_option_id')->constrained('chat_poll_options')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('user')->cascadeOnDelete();
            $table->timestamp('created_at')->nullable();

            $table->unique(['chat_poll_option_id', 'user_id']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_poll_votes');
    }
};
