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
        Schema::create('application_organizational_experience_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_snapshot_id')
                ->constrained('application_profile_snapshots')->cascadeOnDelete()->name('app_org_exp_snap_fk');

            $table->string('organization_name');
            $table->string('position');
            $table->string('level')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreignUuid('organizational_experience_id')->nullable()
                ->constrained('organizational_experiences')->nullOnDelete()
                ->name('org_exp_snap_fk');

            $table->timestamps();
            $table->index(['application_snapshot_id'], 'application_snapshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_organizational_experience_snapshots');
    }
};
