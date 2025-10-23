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
        Schema::create('pre_medical_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pre_medical_result_id')->constrained('pre_medical_results')->cascadeOnDelete();

            $table->text('personal_history')->nullable(); // DM, HTN, asma, TB, dll.
            $table->text('family_history')->nullable();
            $table->text('allergies')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('past_surgeries')->nullable();

            $table->enum('smoking_status', ['never', 'former', 'current'])->nullable();
            $table->enum('alcohol_use', ['never', 'occasional', 'regular'])->nullable();

            $table->text('other_notes')->nullable();

            $table->timestamps();
            $table->unique(['pre_medical_result_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_histories');
    }
};
