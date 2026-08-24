<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'peserta_id',
        'tanggal',
        'status',
        'keterangan',
        'logbook',
        'foto_kegiatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
