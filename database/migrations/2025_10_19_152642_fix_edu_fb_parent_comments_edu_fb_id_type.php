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
        Schema::table('edu_fb_parent_comments', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['edu_fb_id']);
            
            // Drop the existing index
            $table->dropIndex(['edu_fb_id']);
            
            // Change the column type from varchar to bigint
            $table->unsignedBigInteger('edu_fb_id')->change();
            
            // Recreate the index
            $table->index('edu_fb_id');
            
            // Recreate the foreign key constraint
            $table->foreign('edu_fb_id')->references('id')->on('edu_fb')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edu_fb_parent_comments', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['edu_fb_id']);
            
            // Drop the index
            $table->dropIndex(['edu_fb_id']);
            
            // Change the column type back to varchar
            $table->string('edu_fb_id', 50)->change();
            
            // Recreate the index
            $table->index('edu_fb_id');
            
            // Recreate the foreign key constraint with the old table name
            $table->foreign('edu_fb_id')->references('id')->on('educator_feedbacks')->onDelete('cascade');
        });
    }
};
