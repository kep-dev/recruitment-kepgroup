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
        Schema::create('application_language_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_snapshot_id')
                ->constrained('application_profile_snapshots')->cascadeOnDelete()->name('app_language_snap_fk');

            $table->string('language');
            $table->string('level');

            $table->foreignUuid('language_id')->nullable()
                ->constrained('languages')->nullOnDelete()
                ->name('language_snap_fk');

            $table->timestamps();
            $table->index(['application_snapshot_id'], 'application_snapshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_language_snapshots');
    }
};
