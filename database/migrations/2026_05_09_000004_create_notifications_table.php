<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('deadline_id')->nullable();
            $table->enum('channel', ['email', 'push', 'in_app'])->default('in_app');
            $table->text('message');
            $table->integer('remind_days_before')->default(1);
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('deadline_id')->references('id')->on('deadlines')->nullOnDelete();
            $table->index('user_id');
            $table->index('is_sent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
