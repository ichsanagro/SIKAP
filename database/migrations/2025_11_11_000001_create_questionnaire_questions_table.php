<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('questionnaire_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_template_id')->constrained()->cascadeOnDelete();
            $table->text('question_text');
            $table->enum('question_type', ['text', 'textarea', 'radio', 'checkbox', 'select']);
            $table->json('options')->nullable(); // untuk radio, checkbox, select
            $table->boolean('is_required')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('questionnaire_questions');
    }
};
