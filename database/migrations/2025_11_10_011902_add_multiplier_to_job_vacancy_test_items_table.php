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
            $table->float('multiplier')->default(5)->after('duration_in_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancy_test_items', function (Blueprint $table) {
            $table->dropColumn('multiplier');
        });
    }
};
