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
        Schema::create('pre_medical_supporting_examinations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pre_medical_result_id')
                ->constrained('pre_medical_results', 'id')
                ->cascadeOnDelete()
                ->name('pmse_result_fk');
            $table->text('complete_blood')->nullable();
            $table->text('colesterol')->nullable();
            $table->text('blood_sugar')->nullable();
            $table->text('gout')->nullable();
            $table->text('ro')->nullable();
            $table->text('others')->nullable();
            $table->timestamps();

            $table->unique([
                'pre_medical_result_id',
            ], 'pre_medical_supporting_examination_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_supporting_examinations');
    }
};
