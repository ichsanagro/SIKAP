<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mentoring_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_application_id')->constrained('kp_applications')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->text('topic');
            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable();
            $table->enum('status', ['PENDING','APPROVED','REVISION'])->default('PENDING');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mentoring_logs');
    }
};
