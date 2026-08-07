<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'peserta_id',
        'pembimbing_id',
        'no_sertifikat',
        'kedisiplinan',
        'kerapian',
        'kebersihan',
        'tanggung_jawab',
        'kerjasama',
        'kreativitas',
        'kejujuran',
        'nilai_angka',
        'keterangan',
        'status_administrasi',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }

    public function getPredikatAttribute(): string
    {
        $nilai = (float) $this->nilai_angka;

        if ($nilai >= 85) {
            return 'Sangat Baik';
        } elseif ($nilai >= 75) {
            return 'Baik';
        } elseif ($nilai >= 60) {
            return 'Cukup';
        } else {
            return 'Kurang';
        }
    }
}
