<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StatusController extends Controller
{
    public function index(): View
    {
        $peserta = auth()->user()->peserta?->load(['pengajuan', 'bidang', 'pembimbing', 'instansi']);

        return view('peserta.status', compact('peserta'));
    }
}
