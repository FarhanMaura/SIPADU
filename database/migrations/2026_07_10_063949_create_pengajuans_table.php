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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_instansi')->nullable();
            $table->string('pic_nama');
            $table->string('pic_email');
            $table->string('pic_telp');
            $table->integer('jml_peserta');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('file_surat')->nullable();
            $table->string('file_peserta')->nullable();
            $table->string('status')->default('pending');
            $table->text('keterangan')->nullable();
            $table->text('keterangan_reject')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
