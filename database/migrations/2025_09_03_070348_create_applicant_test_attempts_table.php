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
        Schema::create('applicant_test_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('applicant_test_id')->constrained('applicant_tests')->cascadeOnDelete();
            $table->foreignUuid('job_vacancy_test_item_id')->constrained('job_vacancy_test_items')->cascadeOnDelete();
            $table->foreignUuid('test_id')->constrained('tests')->cascadeOnDelete();

            $table->unsignedInteger('attempt_no')->default(1);
            $table->enum('status', ['in_progress', 'submitted', 'graded', 'expired'])->default('in_progress');
            $table->enum('ended_reason', ['timeout', 'submitted', 'manual', 'expired_window'])->nullable();
            $table->decimal('score', 8, 2)->nullable();

            $table->dateTime('started_at')->useCurrent();
            $table->dateTime('deadline_at')->nullable(); // started_at + duration
            $table->dateTime('submitted_at')->nullable();

            // opsional, kalau ingin reproducible random:
            $table->unsignedBigInteger('random_seed')->nullable();

            $table->timestamps();
            $table->unique(['applicant_test_id', 'job_vacancy_test_item_id'], 'attempt_unique'); // 1 attempt per item
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_test_attempts');
    }
};
