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
        Schema::create('pre_medical_eyes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pre_medical_result_id')->constrained('pre_medical_results')->cascadeOnDelete();

            // ketajaman penglihatan (string supaya fleksibel: "6/6", "20/20", dsb.)
            $table->string('va_unaided_right', 20)->nullable();
            $table->string('va_unaided_left', 20)->nullable();
            $table->string('va_aided_right', 20)->nullable();
            $table->string('va_aided_left', 20)->nullable();

            // buta warna
            $table->enum('color_vision', ['normal', 'partial', 'total'])->nullable();

            // bagian mata
            $table->text('conjunctiva')->nullable();
            $table->text('sclera')->nullable();
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
        Schema::dropIfExists('pre_medical_eyes');
    }
};
