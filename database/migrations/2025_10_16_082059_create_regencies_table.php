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
        Schema::create('regencies', function (Blueprint $table) {
            $table->string('code', 10)->primary();   // ex: "3174"
            $table->string('province_code', 10);
            $table->string('name');
            $table->timestamps();

            $table->foreign('province_code')->references('code')->on('provinces')
                ->cascadeOnUpdate()->restrictOnDelete();
            $table->index('province_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regencies');
    }
};
