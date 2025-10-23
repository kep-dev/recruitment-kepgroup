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
        Schema::create('dental_teeths', function (Blueprint $table) {
            $table->smallIncrements('id');                // PK kecil
            $table->unsignedTinyInteger('fdi_code');      // 11..48 (dewasa), 51..85 (susu)
            $table->unsignedTinyInteger('quadrant');      // 1..4 (dewasa), 5..8 (susu)
            $table->unsignedTinyInteger('tooth_number');  // 1..8
            $table->enum('dentition', ['permanent', 'primary']); // dewasa/susu
            $table->string('name')->nullable();           // mis. UR1, UL6, dsb
            $table->string('tooth_type')->nullable();
            $table->unique(['fdi_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_teeths');
    }
};
