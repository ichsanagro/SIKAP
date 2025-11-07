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
        Schema::create('supervisor_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('report')->default(0); // Laporan Kerja Praktek
            $table->unsignedTinyInteger('presentation')->default(0); // Presentasi dan Pemahaman Materi
            $table->unsignedTinyInteger('attitude')->default(0); // Sikap dan Etika
            $table->decimal('final_score', 5, 2)->default(0);
            $table->string('grade', 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['kp_application_id', 'supervisor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_scores');
    }
};
