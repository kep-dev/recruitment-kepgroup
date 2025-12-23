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
        Schema::create('pre_medical_exam_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subsection_id')->constrained('pre_medical_exam_sub_sections')->cascadeOnDelete();
            $table->string('code');      // bj, murmur, vesikuler
            $table->string('name');      // BJ, Murmur, Vesikuler
            $table->enum('value_type', ['yes_no', 'normal_abnormal']);
            $table->unsignedTinyInteger('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_exam_items');
    }
};
