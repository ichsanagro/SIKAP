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
        Schema::table('kp_scores', function (Blueprint $table) {
            $table->unsignedTinyInteger('mastery')->default(0)->after('report');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kp_scores', function (Blueprint $table) {
            $table->dropColumn('mastery');
        });
    }
};
