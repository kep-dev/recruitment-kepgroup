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
        Schema::create('psychotest_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('attempt_id')
                ->constrained('psychotest_attempts')
                ->cascadeOnDelete();

            $table->foreignUuid('question_id')
                ->constrained('psychotest_questions')
                ->cascadeOnDelete();

            $table->foreignUuid('option_id')
                ->constrained('psychotest_question_options')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_answers');
    }
};
