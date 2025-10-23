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
        Schema::create('pre_medical_obgyns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pre_medical_result_id')->constrained('pre_medical_results')->cascadeOnDelete();

            $table->boolean('is_pregnant')->nullable();
            $table->date('lmp_date')->nullable(); // last menstrual period
            $table->unsignedTinyInteger('gravida')->nullable(); // G
            $table->unsignedTinyInteger('para')->nullable();    // P
            $table->unsignedTinyInteger('abortus')->nullable(); // A

            $table->text('uterus_exam')->nullable();
            $table->text('adnexa_exam')->nullable();
            $table->text('cervix_exam')->nullable();
            $table->text('others')->nullable();

            $table->timestamps();
            $table->unique(['pre_medical_result_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_obgyns');
    }
};
