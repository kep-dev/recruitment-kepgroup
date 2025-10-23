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
        Schema::create('pre_medical_session_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('pre_medical_session_id')->constrained('pre_medical_sessions')->cascadeOnDelete();
            $table->foreignUuid('application_id')->constrained()->cascadeOnDelete();

            // slot individu (jika ada penjadwalan per kandidat)
            $table->dateTime('timeslot_start')->nullable();
            $table->dateTime('timeslot_end')->nullable();

            // status kehadiran/proses pemeriksaan
            $table->enum('status', ['scheduled', 'checked_in', 'completed', 'no_show', 'rescheduled', 'canceled'])
                ->default('scheduled');

            // hasil akhir medis per kandidat
            $table->enum('result_status', ['pending', 'fit', 'fit_with_notes', 'unfit'])->default('pending');
            $table->text('result_note')->nullable();

            // file hasil (opsional; PDF dari klinik)
            $table->string('result_file_path')->nullable();

            // audit/reviewer internal
            $table->foreignUuid('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('reviewed_at')->nullable();

            $table->timestamps();

            $table->unique(['pre_medical_session_id', 'application_id'], 'unique_pmcusession_app');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_session_applications');
    }
};
