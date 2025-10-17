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
        Schema::create('villages', function (Blueprint $table) {
            $table->string('code', 10)->primary();   // ex: "3174050001"
            $table->string('district_code', 10);
            $table->string('name');
            $table->timestamps();

            $table->foreign('district_code')->references('code')->on('districts')
                ->cascadeOnUpdate()->restrictOnDelete();
            $table->index('district_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
