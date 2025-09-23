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
        Schema::create('interview_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Opsional: kaitkan ke lowongan tertentu (bisa null untuk sesi lintas lowongan)
            $table->foreignUuid('job_vacancy_id')->nullable()->constrained('job_vacancies')->nullOnDelete();

            $table->foreignUuid('interview_id')->constrained('interviews')->cascadeOnDelete();

            $table->string('title'); // contoh: "Tes Interview Lowongan Engineer 2025"

            // Jadwal & default setting untuk seluruh sesi
            $table->dateTime('scheduled_at');
            $table->dateTime('scheduled_end_at')->nullable();
            $table->enum('default_mode', ['onsite', 'online', 'hybrid'])->default('online');
            $table->string('default_location')->nullable();
            $table->string('default_meeting_link')->nullable();

            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'canceled'])->default('scheduled');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_sessions');
    }
};
