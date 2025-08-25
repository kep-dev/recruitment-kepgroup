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
        Schema::create('applicant_tests', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Lamaran (pelamar + lowongan)
            $table->foreignUuid('application_id')->constrained()->cascadeOnDelete();

            // Paket yang ditugaskan
            $table->foreignUuid('job_vacancy_test_id')->constrained('job_vacancy_tests')->cascadeOnDelete();

            // Satu token untuk akses seluruh paket (semua item di dalamnya)
            $table->string('access_token')->unique();

            $table->enum('status', ['assigned', 'in_progress', 'completed', 'expired'])->default('assigned');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->decimal('total_score', 8, 2)->nullable(); // agregat dari item
            $table->timestamps();

            $table->unique(['application_id', 'job_vacancy_test_id']); // 1 pelamar 1 kali per paket
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_tests');
    }
};
