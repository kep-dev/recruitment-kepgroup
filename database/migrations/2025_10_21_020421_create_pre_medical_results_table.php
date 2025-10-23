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
        Schema::create('pre_medical_results', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK ke peserta di sesi PMCU
            $table->foreignUuid('pre_medical_session_application_id')
                ->constrained('pre_medical_session_applications')->cascadeOnDelete();

            // ringkasan / keputusan akhir
            $table->enum('overall_status', ['pending', 'fit', 'fit_with_notes', 'unfit'])->default('pending');
            $table->text('overall_note')->nullable();

            // pemeriksa internal/eksternal (opsional)
            $table->foreignUuid('examined_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('examined_at')->nullable();

            $table->timestamps();

            $table->unique(['pre_medical_session_application_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_medical_results');
    }
};
