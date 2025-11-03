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
        Schema::create('employeement_proposals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // sumber dari proses rekrutmen
            $table->foreignUuid('application_id')->constrained()->cascadeOnDelete();

            // snapshot info penting (menghindari perubahan data master di kemudian hari)
            $table->string('candidate_name');
            $table->string('candidate_email')->nullable();
            $table->string('candidate_phone')->nullable();

            // penempatan & jabatan (refer ke master yang sudah kamu punya)
            $table->foreignUuid('job_vacancy_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('placement_id')->nullable()->constrained('placements')->nullOnDelete();
            $table->foreignUuid('job_level_id')->nullable()->constrained('job_levels')->nullOnDelete();

            // jenis hubungan kerja & mode kerja
            $table->enum('employment_type', ['permanent', 'contract', 'intern'])->default('contract');
            $table->enum('work_mode', ['wfo', 'wfh', 'hybrid'])->default('wfo');

            // detail kontrak
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();              // untuk kontrak/intern
            $table->unsignedTinyInteger('probation_months')->default(3);

            // kompensasi & benefit
            $table->decimal('base_salary', 15, 2)->nullable();
            $table->json('allowances_json')->nullable();       // tunjangan (transport, makan, dll)
            $table->json('benefit_ids')->nullable();           // refer id benefit yang dipilih
            $table->json('notes_json')->nullable();            // catatan HR, special terms

            // lampiran (opsional)
            $table->string('offer_letter_path')->nullable();

            // audit
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeement_proposals');
    }
};
