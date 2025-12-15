<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table): void {
            $table->boolean('is_submitted')->default(false)->after('final_status');
            $table->timestamp('submitted_at')->nullable()->after('is_submitted');
            $table->uuid('submitted_by')->nullable()->after('submitted_at');
            $table->string('external_id')->nullable()->after('submitted_by');
            $table->string('external_status')->nullable()->after('external_id');

            $table->index('submitted_by');
            $table->index('external_id');

            $table->foreign('submitted_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table): void {
            $table->dropForeign(['submitted_by']);
            $table->dropIndex(['submitted_by']);
            $table->dropIndex(['external_id']);

            $table->dropColumn([
                'is_submitted',
                'submitted_at',
                'submitted_by',
                'external_id',
                'external_status',
            ]);
        });
    }
};
