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
        Schema::create('pre_medical_exam_sub_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('pre_medical_exam_sections')->cascadeOnDelete();
            $table->string('code');   // heart, lung, liver, spleen
            $table->string('name');   // Jantung, Paru, Hati, Limpa
            $table->unsignedTinyInteger('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_exam_sub_sections');
    }
};
