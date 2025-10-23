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
        Schema::create('dental_statuses', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code', 2);                   // D, M, F, K, P, G, S, O
            $table->string('label');                     // Decay, Missing, ...
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unique(['code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_statuses');
    }
};
