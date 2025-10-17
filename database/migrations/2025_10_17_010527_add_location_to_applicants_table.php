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
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('village_code', 10)->nullable()->index();
            $table->foreign('village_code')->references('code')->on('villages')
                ->cascadeOnUpdate()->nullOnDelete();
            $table->string('address_line')->nullable();
            $table->string('postal_code', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropForeign(['village_code']);
            $table->dropColumn(['village_code', 'address_line', 'postal_code']);
        });
    }
};
