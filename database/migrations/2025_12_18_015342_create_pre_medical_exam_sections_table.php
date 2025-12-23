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
        Schema::create('pre_medical_exam_sections', function (Blueprint $table) {
            $table->id();
            $table->string('code');   // chest, abdomen
            $table->string('name');   // Dada, Perut
            $table->unsignedTinyInteger('order')->nullable();
            $table->enum('type', ['physic', 'ent', 'tooth', 'eye', 'gyanaecolonical'])->default('physic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_exam_sections');
    }
};
