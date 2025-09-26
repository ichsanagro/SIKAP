<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kp_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->enum('placement_option', ['1','2','3']); // 1/2 dari prodi, 3 cari sendiri
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->string('custom_company_name')->nullable();
            $table->string('custom_company_address')->nullable();
            $table->date('start_date')->nullable(); // wajib di opsi 3
            $table->enum('status', [
                'DRAFT','SUBMITTED','VERIFIED_PRODI','ASSIGNED_SUPERVISOR',
                'APPROVED','REJECTED','COMPLETED'
            ])->default('DRAFT');
            $table->foreignId('assigned_supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('field_supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable(); // catatan verifikator
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('kp_applications');
    }
};
