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
        Schema::table('pre_medical_item_checks', function (Blueprint $table) {
            // drop foreign key lama
            $table->dropForeign(['physical_exam_item_id']);

            // rename column
            $table->renameColumn('physical_exam_item_id', 'pre_medical_exam_item_id');
        });

        Schema::table('pre_medical_item_checks', function (Blueprint $table) {
            // tambah foreign key baru
            $table->foreign('pre_medical_exam_item_id')
                ->references('id')
                ->on('pre_medical_exam_items')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pre_medical_item_checks', function (Blueprint $table) {
            // drop foreign key baru
            $table->dropForeign(['pre_medical_exam_item_id']);

            // rename kembali
            $table->renameColumn('pre_medical_exam_item_id', 'physical_exam_item_id');
        });

        Schema::table('pre_medical_item_checks', function (Blueprint $table) {
            // foreign key lama
            $table->foreign('physical_exam_item_id')
                ->references('id')
                ->on('pre_medical_exam_items')
                ->cascadeOnDelete();
        });
    }
};
