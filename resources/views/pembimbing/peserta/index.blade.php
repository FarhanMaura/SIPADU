@extends('layouts.adminlte')
@section('title', 'Peserta Bimbingan')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-users"></i> Peserta Bimbingan</h1>
        <p>Daftar peserta magang yang dibimbing oleh Anda.</p>
    </div>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Peserta</h3>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>NIM/NISN</th>
                    <th>Jurusan</th>
                    <th>Instansi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $p->nama }}</td>
                    <td>{{ $p->nim_nisn ?? '-' }}</td>
                    <td>{{ $p->jurusan ?? '-' }}</td>
                    <td>{{ $p->instansi?->nama ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada peserta yang ditugaskan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
