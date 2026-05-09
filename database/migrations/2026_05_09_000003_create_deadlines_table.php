<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deadlines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('subject_id')->nullable();
            $table->string('title');
            $table->enum('type', ['tugas', 'ujian', 'presentasi', 'lainnya'])->default('tugas');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('due_date');
            $table->text('notes')->nullable();
            $table->boolean('is_done')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->nullOnDelete();
            $table->index('user_id');
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deadlines');
    }
};
