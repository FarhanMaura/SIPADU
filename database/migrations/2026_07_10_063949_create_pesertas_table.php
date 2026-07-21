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
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pengajuan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('instansi_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bidang_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pembimbing_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nim_nisn')->nullable();
            $table->string('nama');
            $table->string('jurusan')->nullable();
            $table->string('jenis_peserta')->nullable(); // Mahasiswa / Peserta Didik
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->string('status')->default('aktif'); // aktif / selesai
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
