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
        Schema::create('edu_fb_parent_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('edu_fb_id');
            $table->text('comment');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->timestamp('edited_at')->nullable();

            // Indexes for performance
            $table->index('edu_fb_id');
            $table->index('created_by');
            $table->index('created_at');

            // Foreign keys
            $table->foreign('edu_fb_id')->references('id')->on('edu_fb')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edu_fb_parent_comments');
    }
};
