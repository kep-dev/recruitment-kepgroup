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
        Schema::create('job_vacancy_stages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('job_vacancy_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('stage_type_id')->constrained('stage_types');
            $table->unsignedInteger('order');               // urutan eksekusi tahap
            $table->boolean('is_required')->default(true);  // bisa di-skip jika false
            // $table->json('config')->nullable();             // mis. { "test_ids": ["...","..."], "deadline_days": 7 }
            $table->timestamps();

            $table->unique(['job_vacancy_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancy_stages');
    }
};
