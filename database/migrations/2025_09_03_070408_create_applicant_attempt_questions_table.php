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
        Schema::create('applicant_attempt_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('applicant_test_attempt_id')->constrained('applicant_test_attempts')->cascadeOnDelete();
            $table->foreignUuid('question_id')->constrained('questions')->cascadeOnDelete();
            $table->unsignedInteger('order_index')->default(1); // urutan tampil

            $table->timestamps();
            $table->unique(['applicant_test_attempt_id', 'question_id'], 'attempt_question_unique'); // cegah duplikat soal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_attempt_questions');
    }
};
