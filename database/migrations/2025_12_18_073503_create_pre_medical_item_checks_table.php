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
        Schema::create('pre_medical_item_checks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('checkable');
            $table->foreignId('physical_exam_item_id')->constrained('pre_medical_exam_items')->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_item_checks');
    }
};
