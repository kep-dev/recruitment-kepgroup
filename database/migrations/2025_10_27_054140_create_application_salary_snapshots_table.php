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
        Schema::create('application_salary_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_snapshot_id')
                ->constrained('application_profile_snapshots')->cascadeOnDelete()
                ->name('app_salary_snap_fk');

            $table->decimal('expected_salary', 15, 2)->nullable();
            $table->decimal('current_salary', 15, 2)->nullable();
            $table->string('currency', 10)->default('IDR');

            $table->foreignUuid('salary_id')->nullable()
                ->constrained('salaries')->nullOnDelete()
                ->name('salary_snap_fk');

            $table->timestamps();
            $table->unique(['application_snapshot_id'], 'application_snapshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_salary_snapshots');
    }
};
