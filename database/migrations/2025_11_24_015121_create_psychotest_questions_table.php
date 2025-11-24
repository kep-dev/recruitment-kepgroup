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
        Schema::create('psychotest_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('psychotest_form_id')
                ->constrained('psychotest_forms')
                ->cascadeOnDelete();

            $table->unsignedInteger('number'); // Nomor soal dalam form
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_questions');
    }
};
