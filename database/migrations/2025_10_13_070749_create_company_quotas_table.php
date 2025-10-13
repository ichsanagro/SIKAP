<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('company_quotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('period');          // contoh: 2025-Ganjil / 2025-Genap
            $table->unsignedInteger('quota');  // jumlah maksimal mahasiswa diterima instansi pada periode tsb
            $table->timestamps();
            $table->unique(['company_id', 'period']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('company_quotas');
    }
};
