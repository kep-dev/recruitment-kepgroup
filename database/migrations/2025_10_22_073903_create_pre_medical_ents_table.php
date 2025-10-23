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
        Schema::create('pre_medical_ents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pre_medical_result_id')->constrained('pre_medical_results')->cascadeOnDelete();

            $table->text('ear')->nullable();
            $table->text('nose')->nullable();
            $table->text('throat')->nullable();
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
        Schema::dropIfExists('pre_medical_ents');
    }
};
