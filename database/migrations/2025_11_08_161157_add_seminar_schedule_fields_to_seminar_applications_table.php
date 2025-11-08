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
            $table->date('seminar_date')->nullable();
            $table->time('seminar_time')->nullable();
            $table->string('seminar_location')->nullable();
            $table->text('examiner_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminar_applications', function (Blueprint $table) {
            $table->dropColumn(['seminar_date', 'seminar_time', 'seminar_location', 'examiner_notes']);
        });
    }
};
