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
        Schema::table('job_vacancy_tests', function (Blueprint $table) {
            $table->enum('type', ['general', 'psychotest'])
                ->default('general')
                ->after('job_vacancy_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancy_tests', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
