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
        Schema::create('examiner_seminar_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('examiner_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('laporan')->default(0); // Laporan Kerja Praktek
            $table->unsignedTinyInteger('presentasi')->default(0); // Presentasi dan Pemahaman Materi
            $table->unsignedTinyInteger('sikap')->default(0); // Sikap dan Etika
            $table->text('catatan')->nullable();
            $table->unsignedTinyInteger('total_skor')->default(0);
            $table->decimal('rata_rata', 5, 2)->default(0);
            $table->string('nilai_huruf', 2)->nullable();
            $table->timestamps();
            $table->unique(['kp_application_id', 'examiner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examiner_seminar_scores');
    }
};
