<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'MAHASISWA',
                'ADMIN_PRODI',
                'DOSEN_SUPERVISOR',
                'PENGAWAS_LAPANGAN',
                'SUPERADMIN',
            ])->default('MAHASISWA')->after('email');
            $table->string('nim')->nullable()->after('name');     // untuk mahasiswa
            $table->string('prodi')->nullable()->after('nim');    // contoh field tambahan
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','nim','prodi']);
        });
    }
};
