<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('questionnaire_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_template_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kp_application_id')->nullable()->constrained()->nullOnDelete();
            $table->json('responses'); // menyimpan semua jawaban dalam format JSON
            $table->timestamp('submitted_at');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('questionnaire_responses');
    }
};
