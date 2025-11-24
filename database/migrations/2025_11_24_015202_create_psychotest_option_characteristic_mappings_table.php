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
        Schema::create('psychotest_option_characteristic_mappings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('option_id')
                ->constrained('psychotest_question_options')
                ->cascadeOnDelete()
                ->name('fk_option');

            $table->foreignUuid('aspect_id')
                ->constrained('psychotest_aspects')
                ->cascadeOnDelete()
                ->name('fk_aspect');

            $table->foreignUuid('characteristic_id')
                ->constrained('psychotest_characteristics')
                ->cascadeOnDelete()
                ->name('fk_characteristic');

            $table->tinyInteger('weight')->default(1);

            $table->timestamps();

            // beri nama unik index secara manual
            $table->unique(['option_id', 'characteristic_id'], 'uq_option_characteristic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_option_characteristic_mappings');
    }
};
