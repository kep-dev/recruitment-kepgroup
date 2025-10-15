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
        Schema::table('job_vacancy_test_items', function (Blueprint $table) {
            $table->integer('minimum_score')->default(0)->after('test_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancy_test_items', function (Blueprint $table) {
            $table->dropColumn('minimum_score');
        });
    }
};
