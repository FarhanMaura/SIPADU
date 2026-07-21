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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pembimbing_id')->nullable()->constrained()->nullOnDelete();
            $table->string('no_sertifikat')->nullable();
            $table->integer('kedisiplinan')->nullable();
            $table->integer('kerapian')->nullable();
            $table->integer('kebersihan')->nullable();
            $table->integer('tanggung_jawab')->nullable();
            $table->integer('kerjasama')->nullable();
            $table->integer('kreativitas')->nullable();
            $table->integer('kejujuran')->nullable();
            $table->decimal('nilai_angka', 5, 2)->nullable(); // rata-rata
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
