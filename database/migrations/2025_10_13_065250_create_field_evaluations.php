<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('field_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->default(0);
            $table->text('evaluation')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->index(['kp_application_id','supervisor_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('field_evaluations');
    }
};
