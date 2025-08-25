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
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('job_vacancy_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('current_stage_id')->nullable()->constrained('job_vacancy_stages');
            $table->enum('final_status', ['pending', 'hired', 'rejected'])->default('pending');
            $table->dateTime('applied_at')->default(now());
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
