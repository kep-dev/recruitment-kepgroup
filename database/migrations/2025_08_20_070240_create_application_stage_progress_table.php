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
        Schema::create('application_stage_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('job_vacancy_stage_id')->constrained('job_vacancy_stages')->cascadeOnDelete();

            // status tahap untuk lamaran ini
            $table->enum('status', ['pending', 'in_progress', 'passed', 'failed', 'skipped'])->default('pending');

            // waktu & aktor
            $table->timestamp('started_at')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->foreignUuid('decided_by')->nullable()->constrained('users'); // HR/Interviewer
            $table->text('note')->nullable();

            // scoring opsional per tahap (mis. nilai tes / interview)
            $table->decimal('score', 8, 2)->nullable();
            // $table->json('meta')->nullable(); // simpan data tambahan spesifik tahap (mis. rubric penilaian)

            $table->timestamps();

            $table->unique(['application_id', 'job_vacancy_stage_id'], 'application_stage_unique');
            $table->index(['application_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_stage_progress');
    }
};
