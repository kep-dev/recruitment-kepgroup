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
        Schema::create('pre_medical_physicals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pre_medical_result_id')->constrained('pre_medical_results')->cascadeOnDelete();

            // angka & unit
            $table->decimal('height_cm', 5, 2)->nullable();          // cm
            $table->decimal('weight_kg', 5, 2)->nullable();          // kg
            $table->unsignedSmallInteger('bp_systolic')->nullable(); // mmHg
            $table->unsignedSmallInteger('bp_diastolic')->nullable(); // mmHg
            $table->unsignedSmallInteger('heart_rate_bpm')->nullable();
            $table->unsignedSmallInteger('resp_rate_per_min')->nullable();
            $table->decimal('temperature_c', 4, 1)->nullable();

            // deskriptif
            $table->text('head_neck')->nullable();
            $table->text('chest_heart')->nullable();
            $table->text('chest_lung')->nullable();
            $table->text('abdomen_liver')->nullable();
            $table->text('abdomen_spleen')->nullable();
            $table->text('extremities')->nullable();
            $table->text('others')->nullable();

            // opsional: BMI tersimpan
            $table->decimal('bmi', 5, 2)->nullable();

            $table->timestamps();
            $table->unique(['pre_medical_result_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_physicals');
    }
};
