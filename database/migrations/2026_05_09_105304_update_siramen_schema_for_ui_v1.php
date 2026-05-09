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
        // 1. Update Summaries
        Schema::table('summaries', function (Blueprint $table) {
            $table->float('ai_probability')->default(0)->after('content_md');
            $table->json('tags')->nullable()->after('ai_probability');
        });

        // 2. Update Deadlines (Enum update logic depends on DB, but we can add UTS/Seminar as common strings)
        // Note: Changing ENUM in Laravel is tricky without raw SQL, let's keep it flexible
        Schema::table('deadlines', function (Blueprint $table) {
            $table->string('type')->change(); // make it string for flexibility
        });

        // 3. Teams (Planner Tugas Kelompok)
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id'); // Creator
            $table->uuid('subject_id')->nullable();
            $table->string('name');
            $table->date('deadline_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->nullOnDelete();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id');
            $table->uuid('user_id');
            $table->string('role')->default('Anggota');
            $table->integer('progress_percent')->default(0);
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('team_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id');
            $table->string('title');
            $table->uuid('pic_id')->nullable(); // User ID
            $table->string('status')->default('Menunggu'); // Selesai, Sedang Jalan, Menunggu
            $table->string('priority')->default('low'); // low, medium, high
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreign('pic_id')->references('id')->on('users')->nullOnDelete();
        });

        // 4. Document Templates
        Schema::create('document_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('category')->default('Akademik');
            $table->json('parameters'); // Field yang harus diisi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_templates');
        Schema::dropIfExists('team_tasks');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('teams');
        
        Schema::table('summaries', function (Blueprint $table) {
            $table->dropColumn(['ai_probability', 'tags']);
        });
    }
};
