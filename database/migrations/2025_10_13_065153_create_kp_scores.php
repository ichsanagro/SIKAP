<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kp_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('discipline')->default(0);
            $table->unsignedTinyInteger('skill')->default(0);
            $table->unsignedTinyInteger('attitude')->default(0);
            $table->unsignedTinyInteger('report')->default(0);
            $table->decimal('final_score', 5, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['kp_application_id', 'supervisor_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('kp_scores');
    }
};
