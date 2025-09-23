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
        Schema::create('interview_evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('interview_session_application_id')->constrained('interview_session_applications')->cascadeOnDelete();
            $table->foreignUuid('interview_session_evaluator_id')->constrained('interview_session_evaluators')->cascadeOnDelete();
            $table->decimal('total_score', 8, 2)->nullable();
            $table->enum('recommendation', ['hire', 'hold', 'no_hire'])->nullable();
            $table->text('overall_comment')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['interview_session_application_id', 'interview_session_evaluator_id'], 'interview_eval_unique_app_evaluator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_evaluations');
    }
};
