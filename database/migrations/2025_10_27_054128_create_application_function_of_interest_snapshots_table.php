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
        Schema::create('application_function_of_interest_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_snapshot_id')
                ->constrained('application_profile_snapshots')->cascadeOnDelete()->name('app_function_of_interest_snap_fk');

            $table->string('function_of_interest');

            $table->foreignUuid('function_of_interest_id')->nullable()
                ->constrained('function_of_interests')->nullOnDelete()
                ->name('function_of_interest_snap_fk');

            $table->timestamps();
            $table->index(['application_snapshot_id'], 'application_snapshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_function_of_interest_snapshots');
    }
};
