<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('questionnaire_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_application_id')->constrained('kp_applications')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->json('answers'); // simpan objek jawaban
            $table->timestamp('submitted_at');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('questionnaire_submissions');
    }
};
