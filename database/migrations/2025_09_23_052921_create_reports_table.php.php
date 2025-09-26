<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_application_id')->constrained('kp_applications')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_path');
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status',['SUBMITTED','VERIFIED_PRODI','REVISION','APPROVED'])->default('SUBMITTED');
            $table->unsignedTinyInteger('grade')->nullable(); // opsional
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('reports');
    }
};
