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
        Schema::create('interview_evaluation_scores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('interview_evaluation_id')->constrained('interview_evaluations')->cascadeOnDelete();
            $table->foreignUuid('interview_criteria_id')->constrained('interview_criterias')->cascadeOnDelete();
            $table->foreignUuid('interview_scale_id')->constrained('interview_scales')->cascadeOnDelete();
            $table->string('scale_label_snapshot');
            $table->unsignedTinyInteger('scale_value_snapshot');
            $table->decimal('score_numeric', 8, 2)->nullable(); // jika kamu hitung angka (value/max * weight * 100)
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['interview_evaluation_id', 'interview_criteria_id'], 'interview_eval_scores_unique_eval_interview');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_evaluation_scores');
    }
};
