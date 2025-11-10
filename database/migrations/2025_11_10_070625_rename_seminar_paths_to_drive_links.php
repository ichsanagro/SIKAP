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
        Schema::table('seminar_applications', function (Blueprint $table) {
            $table->renameColumn('kegiatan_harian_path', 'kegiatan_harian_drive_link');
            $table->renameColumn('bimbingan_kp_path', 'bimbingan_kp_drive_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminar_applications', function (Blueprint $table) {
            $table->renameColumn('kegiatan_harian_drive_link', 'kegiatan_harian_path');
            $table->renameColumn('bimbingan_kp_drive_link', 'bimbingan_kp_path');
        });
    }
};
