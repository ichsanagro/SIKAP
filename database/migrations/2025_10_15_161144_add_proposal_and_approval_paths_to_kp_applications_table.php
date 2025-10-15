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
            $table->string('proposal_path')->nullable()->after('krs_path');
            $table->string('approval_path')->nullable()->after('proposal_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kp_applications', function (Blueprint $table) {
            $table->dropColumn(['proposal_path', 'approval_path']);
        });
    }
};
