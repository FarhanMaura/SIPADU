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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('nim_nisn')->nullable()->after('pic_nama');
            $table->string('jenis_peserta')->nullable()->after('nim_nisn');
            $table->string('jurusan')->nullable()->after('jenis_peserta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn(['nim_nisn', 'jenis_peserta', 'jurusan']);
        });
    }
};
