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
        Schema::create('interview_session_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('interview_session_id')->constrained('interview_sessions')->cascadeOnDelete();
            $table->foreignUuid('application_id')->constrained()->cascadeOnDelete();

            // Override per kandidat (jika null → pakai default dari session)
            $table->enum('mode', ['onsite', 'online', 'hybrid'])->nullable();
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();

            // Status per kandidat
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'no_show', 'canceled'])->default('scheduled');

            // Hasil agregat per kandidat di sesi ini
            $table->decimal('avg_score', 8, 2)->nullable();
            $table->enum('recommendation', ['hire', 'hold', 'no_hire'])->nullable();

            $table->timestamps();

            $table->unique(['interview_session_id', 'application_id'], 'unique_interview_application'); // 1 kandidat sekali per sesi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_session_applications');
    }
};
