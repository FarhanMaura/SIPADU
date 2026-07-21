@extends('layouts.adminlte')
@section('title', 'Penilaian Peserta')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-star"></i> Penilaian Peserta</h1>
        <p>Berikan nilai akhir kepada peserta bimbingan Anda.</p>
    </div>
    <a href="{{ route('pembimbing.penilaian.create') }}" class="action-button">
        <i class="fas fa-plus"></i> Beri Nilai
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Penilaian</h3>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Peserta</th>
                    <th>Nilai</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $p->nama }}</td>
                    <td>{!! $p->penilaian?->nilai_angka ? '<strong style="color: #2563eb;">' . $p->penilaian->nilai_angka . '</strong>' : '<em style="color: #94a3b8;">Belum dinilai</em>' !!}</td>
                    <td>{{ $p->penilaian?->keterangan ?? '-' }}</td>
                    <td>
                        <div class="action-icons">
                            @if($p->penilaian)
                            <a href="{{ route('pembimbing.penilaian.edit', $p->penilaian) }}" class="edit"><i class="fas fa-edit"></i> Edit Nilai</a>
                            @else
                            <a href="{{ route('pembimbing.penilaian.create') }}?peserta_id={{ $p->id }}" class="edit" style="color: #16a34a;"><i class="fas fa-check-circle"></i> Beri Nilai</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada peserta bimbingan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
