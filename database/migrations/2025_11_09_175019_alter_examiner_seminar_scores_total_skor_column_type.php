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
        Schema::table('examiner_seminar_scores', function (Blueprint $table) {
            $table->smallInteger('total_skor')->unsigned()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examiner_seminar_scores', function (Blueprint $table) {
            $table->tinyInteger('total_skor')->unsigned()->default(0)->change();
        });
    }
};
