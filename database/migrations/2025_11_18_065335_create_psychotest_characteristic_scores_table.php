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
        Schema::create('psychotest_characteristic_scores', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('psychotest_characteristic_id')
                ->constrained('psychotest_characteristics')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('score'); // 0..9
            $table->text('description');         // keterangan untuk score ini

            $table->timestamps();

            $table->unique(['psychotest_characteristic_id', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_characteristic_scores');
    }
};
