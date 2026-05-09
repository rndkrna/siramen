<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('action'); // contoh: upload_document, complete_quiz, dll
            $table->string('entity_type')->nullable(); // Document, Quiz, Deadline, dll
            $table->uuid('entity_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index('user_id');
            $table->index('created_at');
        });

        Schema::create('api_usage_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('endpoint');
            $table->string('provider'); // openai, gemini, dll
            $table->integer('tokens_used')->default(0);
            $table->decimal('cost_usd', 10, 6)->default(0);
            $table->enum('status', ['success', 'failed', 'timeout'])->default('success');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_usage_logs');
        Schema::dropIfExists('activity_logs');
    }
};
