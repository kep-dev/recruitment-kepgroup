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
        Schema::create('approvals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('approvable');
            $table->foreignUuid('approved_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['APPROVE', 'REJECT', 'REVISI', 'MENUNGGU PERSETUJUAN', 'DIBATALKAN', 'PENDING'])->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
