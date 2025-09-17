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
        Schema::create('applicant_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('applicant_test_attempt_id')->constrained('applicant_test_attempts')->cascadeOnDelete();
            $table->foreignUuid('question_id')->constrained('questions')->cascadeOnDelete();

            // Untuk multiple_choice / true_false → refer ke question_choices
            $table->foreignUuid('selected_choice_id')->nullable()->constrained('question_choices')->cascadeOnDelete();

            // Untuk essay / fill_in_blank / matching → taruh di bawah ini
            $table->longText('answer_text')->nullable(); // essay / fill_in_blank sederhana
            $table->json('answer_json')->nullable();     // struktur kompleks (matching, multiple blanks)

            // Penilaian
            $table->boolean('is_correct')->nullable();   // auto-grade (MC/TF) → true/false; essay → null dulu
            $table->decimal('score', 8, 2)->nullable();  // skor per soal (auto / manual)

            // Waktu
            $table->dateTime('answered_at')->nullable();

            $table->timestamps();

            $table->unique(['applicant_test_attempt_id', 'question_id'], 'attempt_question_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_answers');
    }
};
