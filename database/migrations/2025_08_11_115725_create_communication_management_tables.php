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
        // Create notification_types table
        Schema::create('notification_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('color', 7)->default('#6b7280');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
        });

        // Create notifications table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_type_id')->constrained('notification_types')->onDelete('cascade');
            $table->string('title', 500);
            $table->text('message');
            $table->enum('priority', ['normal', 'high', 'urgent'])->default('normal');
            $table->enum('target_type', ['broadcast', 'user', 'role', 'class', 'grade'])->default('broadcast');
            $table->json('target_data')->nullable();
            $table->string('action_url', 500)->nullable();
            $table->string('action_text', 100)->nullable();
            $table->string('image_url', 500)->nullable();
            $table->boolean('is_scheduled')->default(false);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('total_recipients')->default(0);
            $table->integer('total_sent')->default(0);
            $table->integer('total_delivered')->default(0);
            $table->integer('total_read')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('user')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('user')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('priority');
            $table->index('target_type');
            $table->index(['is_scheduled', 'scheduled_at']);
            $table->index(['expires_at', 'is_active']);
            $table->index('created_by');
            $table->index('sent_at');
        });

        // Create notification_recipients table
        Schema::create('notification_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained('notifications')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_delivered')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->enum('delivery_method', ['in_app', 'push', 'email', 'sms'])->default('in_app');
            $table->timestamps();

            $table->unique(['notification_id', 'user_id']);
            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'is_delivered']);
            $table->index('notification_id');
        });

        // Create announcement_categories table
        Schema::create('announcement_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('color', 7)->default('#6b7280');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
            $table->index('sort_order');
        });

        // Create announcements table
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->foreignId('category_id')->constrained('announcement_categories')->onDelete('cascade');
            $table->tinyInteger('priority_level')->default(1);
            $table->enum('status', ['draft', 'scheduled', 'published', 'archived'])->default('draft');
            $table->enum('target_type', ['broadcast', 'role', 'class', 'grade', 'user'])->default('broadcast');
            $table->json('target_data')->nullable();
            $table->string('image_url', 500)->nullable();
            $table->json('attachment_urls')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->boolean('notification_sent')->default(false);
            $table->foreignId('notification_id')->nullable()->constrained('notifications')->onDelete('set null');
            $table->text('tags')->nullable();
            $table->json('meta_data')->nullable();
            $table->foreignId('created_by')->constrained('user')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('user')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
            $table->index('priority_level');
            $table->index('status');
            $table->index('target_type');
            $table->index(['status', 'published_at']);
            $table->index(['expires_at', 'status']);
            $table->index('is_featured');
            $table->index('is_pinned');
            $table->index('created_by');
        });

        // Create announcement_recipients table
        Schema::create('announcement_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('announcements')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_liked')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('liked_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->timestamps();

            $table->unique(['announcement_id', 'user_id']);
            $table->index(['user_id', 'is_read']);
            $table->index(['announcement_id', 'is_liked']);
            $table->index('announcement_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_recipients');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('announcement_categories');
        Schema::dropIfExists('notification_recipients');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('notification_types');
    }
};
