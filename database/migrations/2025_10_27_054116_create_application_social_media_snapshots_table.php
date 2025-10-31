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
        Schema::create('application_social_media_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_snapshot_id')
                ->constrained('application_profile_snapshots')->cascadeOnDelete()
                ->name('app_social_media_snap_fk');

            $table->string('name');
            $table->string('url');

            $table->foreignUuid('social_media_id')->nullable()
                ->constrained('social_medias')->nullOnDelete()
                ->name('social_media_snap_fk');

            $table->timestamps();
            $table->index(['application_snapshot_id'], 'application_snapshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_social_media_snapshots');
    }
};
