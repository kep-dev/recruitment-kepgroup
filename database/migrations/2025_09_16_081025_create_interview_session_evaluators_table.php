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
        Schema::create('interview_session_evaluators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('interview_session_id')->constrained('interview_sessions')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->nullable(); // lead/panel/observer
            $table->timestamps();

            $table->unique(['interview_session_id', 'user_id'], 'unique_interview_evaluator'); // 1 evaluator sekali per sesi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_session_evaluators');
    }
};
