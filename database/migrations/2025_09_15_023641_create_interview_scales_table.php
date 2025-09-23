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
        Schema::create('interview_scales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('interview_criteria_id')->constrained('interview_criterias')->cascadeOnDelete();

            $table->string('label');                  // "Kurang", "Cukup", "Baik", "Baik Sekali"
            $table->unsignedTinyInteger('value');     // 1..4 (atau sesuai kebutuhan)
            $table->unsignedInteger('order')->default(1);

            $table->timestamps();

            $table->unique(['interview_criteria_id', 'value']);   // pastikan unik per form
            $table->unique(['interview_criteria_id', 'label']);   // label unik per form
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_scales');
    }
};
