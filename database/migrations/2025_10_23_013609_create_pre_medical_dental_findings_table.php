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
        Schema::create('pre_medical_dental_findings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('pre_medical_dental_id')
                ->constrained('pre_medical_dentals')
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('dental_teeth_id');
            $table->foreign('dental_teeth_id')
                ->references('id')->on('dental_teeths')
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('dental_status_id');
            $table->foreign('dental_status_id')
                ->references('id')->on('dental_statuses')
                ->cascadeOnDelete();

            // pakai default 'W' (whole) agar unique index tidak kena kasus NULL
            $table->enum('surface', ['O', 'M', 'D', 'B', 'L', 'P', 'I', 'F', 'W'])
                ->default('W');

            $table->enum('severity', ['mild', 'moderate', 'severe'])->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Cegah duplikasi entri dengan kombinasi yang sama
            $table->unique([
                'pre_medical_dental_id',
                'dental_teeth_id',
                'dental_status_id',
                'surface'
            ], 'uniq_exam_tooth_status_surface');

            // Index bantu untuk query umum
            $table->index(['pre_medical_dental_id', 'dental_teeth_id'], 'idx_exam_tooth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_dental_findings');
    }
};
