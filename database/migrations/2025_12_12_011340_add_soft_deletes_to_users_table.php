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
        $tables = [
            'users',
            'documents',
            'salaries',
            'function_of_interests',
            'social_medias',
            'skills',
            'languages',
            'achievments',
            'training_certifications',
            'organizational_experiences',
            'work_experiences',
            'educations',
            'applicants',
        ];

        foreach ($tables as $table) {
            if (! Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'documents',
            'salaries',
            'function_of_interests',
            'social_medias',
            'skills',
            'languages',
            'achievments',
            'training_certifications',
            'organizational_experiences',
            'work_experiences',
            'educations',
            'applicants',
        ];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
