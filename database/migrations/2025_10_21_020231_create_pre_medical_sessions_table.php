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
        Schema::create('pre_medical_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // opsional: kaitkan dengan lowongan tertentu
            $table->foreignUuid('job_vacancy_id')->nullable()->constrained('job_vacancies')->nullOnDelete();

            $table->string('title'); // contoh: "PMCU Batch Engineer 2025"

            $table->dateTime('scheduled_at');
            $table->dateTime('scheduled_end_at')->nullable();

            $table->string('location')->nullable(); // alamat klinik/jadwal mobile check up
            $table->text('instruction')->nullable(); // puasa, bawa KTP, dsb.

            $table->enum('status', ['draft', 'scheduled', 'in_progress', 'completed', 'canceled'])->default('scheduled');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_sessions');
    }
};
