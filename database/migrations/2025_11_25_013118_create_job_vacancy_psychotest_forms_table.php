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
        Schema::create('job_vacancy_psychotest_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('job_vacancy_test_id')
                ->constrained('job_vacancy_tests')
                ->cascadeOnDelete();

            $table->foreignUuid('psychotest_form_id')
                ->constrained('psychotest_forms')
                ->cascadeOnDelete();

            $table->unsignedInteger('order')->default(1);
            $table->unsignedInteger('duration_minutes')->nullable();

            $table->timestamps();

            $table->unique(
                ['job_vacancy_test_id', 'psychotest_form_id'],
                'jvt_psyform_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancy_psychotest_forms');
    }
};
