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
        Schema::create('psychotest_result_aspects', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('attempt_id')
                ->constrained('psychotest_attempts')
                ->cascadeOnDelete();

            $table->foreignUuid('aspect_id')
                ->constrained('psychotest_aspects')
                ->cascadeOnDelete();

            $table->unsignedInteger('raw_score')->default(0);
            $table->unsignedTinyInteger('scaled_score')->default(0);

            $table->timestamps();

            $table->unique(['attempt_id', 'aspect_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_result_aspects');
    }
};
