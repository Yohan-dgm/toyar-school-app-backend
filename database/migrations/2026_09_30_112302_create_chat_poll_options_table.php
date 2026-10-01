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
        Schema::create('chat_poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_message_poll_id')->constrained('chat_message_polls')->cascadeOnDelete();
            $table->string('option_text', 255);
            $table->smallInteger('position')->default(0);
            $table->timestamps();

            $table->index('chat_message_poll_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_poll_options');
    }
};
