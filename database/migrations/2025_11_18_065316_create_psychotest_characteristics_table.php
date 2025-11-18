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
        Schema::create('psychotest_characteristics', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('psychotest_aspect_id')
                ->constrained('psychotest_aspects')
                ->cascadeOnDelete();

            $table->string('code');   // e.g. 'MENYELESAIKAN_TUGAS_PRIBADI'
            $table->string('name');   // e.g. 'MENYELESAIKAN TUGAS PRIBADI'
            $table->text('description')->nullable(); // deskripsi umum karakteristik
            $table->unsignedInteger('order')->default(0); // urutan dalam aspek

            $table->timestamps();

            $table->unique(['psychotest_aspect_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_characteristics');
    }
};
