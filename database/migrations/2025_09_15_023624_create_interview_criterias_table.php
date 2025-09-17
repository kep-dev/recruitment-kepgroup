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
        Schema::create('interview_criterias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('interview_id')->constrained('interviews')->cascadeOnDelete();
            $table->string('label');                  // contoh: "Pengetahuan Teknis/Akademis"
            $table->text('description')->nullable();
            $table->unsignedInteger('order')->default(1);
            $table->decimal('weight', 5, 2)->default(1.00); // bobot relatif (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_criterias');
    }
};
