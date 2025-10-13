<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('kp_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('kp_applications', 'supervisor_id')) {
                $table->foreignId('supervisor_id')
                      ->nullable()
                      ->after('student_id')
                      ->constrained('users')
                      ->nullOnDelete();
                $table->index('supervisor_id');
            }
        });
    }

    public function down(): void {
        Schema::table('kp_applications', function (Blueprint $table) {
            if (Schema::hasColumn('kp_applications', 'supervisor_id')) {
                $table->dropForeign(['supervisor_id']);
                $table->dropIndex(['supervisor_id']);
                $table->dropColumn('supervisor_id');
            }
        });
    }
};
