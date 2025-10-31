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
        Schema::create('exam_client_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('applicant_test_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('job_vacancy_test_item_id')->constrained()->cascadeOnDelete();
            $table->string('event', 100);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_client_events');
    }
};
