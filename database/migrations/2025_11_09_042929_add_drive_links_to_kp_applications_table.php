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
        Schema::table('kp_applications', function (Blueprint $table) {
            $table->string('krs_drive_link')->nullable()->after('krs_path');
            $table->string('proposal_drive_link')->nullable()->after('proposal_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kp_applications', function (Blueprint $table) {
            $table->dropColumn(['krs_drive_link', 'proposal_drive_link']);
        });
    }
};
