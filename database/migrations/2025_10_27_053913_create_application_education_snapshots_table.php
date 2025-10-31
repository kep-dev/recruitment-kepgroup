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
        Schema::create('application_education_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_snapshot_id')
                ->constrained('application_profile_snapshots')->cascadeOnDelete();

            $table->string('education_level')->nullable();
            $table->string('major')->nullable();
            $table->string('university')->nullable();
            $table->string('location')->nullable();
            $table->year('graduation_year')->nullable();
            $table->decimal('gpa', 4, 2)->nullable();

            $table->foreignUuid('education_id')->nullable()
                ->constrained('educations')->nullOnDelete();

            $table->timestamps();
            $table->index(['application_snapshot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_education_snapshots');
    }
};
