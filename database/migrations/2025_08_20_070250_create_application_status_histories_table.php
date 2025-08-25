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
        Schema::create('application_status_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('job_vacancy_stage_id')->nullable()->constrained('job_vacancy_stages');
            $table->enum('from_status', ['pending', 'in_progress', 'passed', 'failed', 'skipped', 'null'])->default('pending');
            $table->enum('to_status',   ['pending', 'in_progress', 'passed', 'failed', 'skipped']);
            $table->foreignUuid('changed_by')->nullable()->constrained('users');
            $table->text('note')->nullable();
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();

            $table->index(['application_id', 'changed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_status_histories');
    }
};
