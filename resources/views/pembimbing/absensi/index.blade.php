@extends('layouts.adminlte')
@section('title', 'Kelola Absensi')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-calendar-check"></i> Kelola Absensi</h1>
        <p>Manajemen data absensi peserta bimbingan Anda.</p>
    </div>
    <a href="{{ route('pembimbing.absensi.create') }}" class="action-button">
        <i class="fas fa-plus"></i> Input Absensi
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Data Absensi</h3>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Peserta</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $a->peserta?->nama }}</td>
                    <td>{{ $a->tanggal?->format('d/m/Y') }}</td>
                    <td>
                        @if($a->status === 'hadir') <span class="badge-count">Hadir</span>
                        @elseif($a->status === 'izin') <span class="badge-count two" style="background:#fef3c7; color:#d97706;">Izin</span>
                        @elseif($a->status === 'sakit') <span class="badge-count two">Sakit</span>
                        @else <span class="badge-count zero">Alpa</span>
                        @endif
                    </td>
                    <td>{{ $a->keterangan ?? '-' }}</td>
                    <td>
                        <div class="action-icons">
                            <a href="{{ route('pembimbing.absensi.edit', $a) }}" class="edit"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('pembimbing.absensi.destroy', $a) }}" method="POST" style="display: inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada data absensi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($absensis, 'links') && $absensis->hasPages())
    <div class="table-footer">
        {{ $absensis->links() }}
    </div>
    @endif
</div>
@endsection
