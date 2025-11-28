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
        Schema::create('psychotest_question_options', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('psychotest_question_id')
                ->constrained('psychotest_questions')
                ->cascadeOnDelete();

            $table->string('label', 1); // 'A' atau 'B'
            $table->text('statement');
            $table->unsignedTinyInteger('order')->default(1); // 1=A, 2=B

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_question_options');
    }
};
