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
            if (!Schema::hasColumn('pengajuans', 'rekomendasi_instansi')) {
                $table->string('rekomendasi_instansi')->nullable()->after('keterangan_reject');
            }
        });

        Schema::table('penilaians', function (Blueprint $table) {
            if (!Schema::hasColumn('penilaians', 'status_administrasi')) {
                $table->string('status_administrasi')->default('dinilai_pembimbing')->after('keterangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            if (Schema::hasColumn('pengajuans', 'rekomendasi_instansi')) {
                $table->dropColumn('rekomendasi_instansi');
            }
        });

        Schema::table('penilaians', function (Blueprint $table) {
            if (Schema::hasColumn('penilaians', 'status_administrasi')) {
                $table->dropColumn('status_administrasi');
            }
        });
    }
};
