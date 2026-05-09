<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('summaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id');
            $table->longText('content_md'); // konten markdown hasil ringkasan
            $table->json('key_points')->nullable();
            $table->json('possible_questions')->nullable();
            $table->string('language', 10)->default('id');
            $table->integer('tokens_used')->default(0);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('document_id')->references('id')->on('documents')->cascadeOnDelete();
            $table->index('document_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('summaries');
    }
};
