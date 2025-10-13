<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('kp_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('kp_applications', 'verification_status')) {
                $table->enum('verification_status', ['PENDING','APPROVED','REJECTED'])
                      ->default('PENDING')
                      ->after('id');
            }
            if (!Schema::hasColumn('kp_applications', 'verification_notes')) {
                $table->text('verification_notes')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('kp_applications', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()
                      ->after('verification_notes')
                      ->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('kp_applications', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });
    }

    public function down(): void {
        Schema::table('kp_applications', function (Blueprint $table) {
            if (Schema::hasColumn('kp_applications', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
            if (Schema::hasColumn('kp_applications', 'verified_by')) {
                $table->dropConstrainedForeignId('verified_by');
            }
            if (Schema::hasColumn('kp_applications', 'verification_notes')) {
                $table->dropColumn('verification_notes');
            }
            if (Schema::hasColumn('kp_applications', 'verification_status')) {
                $table->dropColumn('verification_status');
            }
        });
    }
};
