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
        Schema::create('psychotest_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('form_id')
                ->constrained('psychotest_forms')
                ->cascadeOnDelete();

            $table->foreignUuid('applicant_test_id')
                ->nullable()
                ->constrained('applicant_tests')
                ->cascadeOnDelete();

            $table->enum('status', ['in_progress', 'submitted', 'graded', 'expired'])->default('in_progress'); // in_progress | completed
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->unsignedInteger('attempt_no')->default(1);
            $table->enum('ended_reason', ['timeout', 'submitted', 'manual', 'expired_window'])->nullable();
            $table->decimal('score', 8, 2)->nullable();
            $table->dateTime('deadline_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_attempts');
    }
};
