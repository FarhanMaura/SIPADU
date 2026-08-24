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
                    <th width="40">#</th>
                    <th>Peserta</th>
                    <th width="110">Tanggal</th>
                    <th width="100">Status</th>
                    <th>Logbook Kegiatan</th>
                    <th width="130">Dokumentasi</th>
                    <th width="130">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600; color: #0f172a;">
                        {{ $a->peserta?->nama }}
                        <small style="display: block; color: #64748b;">{{ $a->peserta?->nim_nisn ?? '-' }}</small>
                    </td>
                    <td style="font-weight: 600;">{{ $a->tanggal?->format('d/m/Y') }}</td>
                    <td>
                        @if($a->status === 'hadir') <span class="badge-count" style="font-size: 0.8rem; padding: 0.25rem 0.6rem;">Hadir</span>
                        @elseif($a->status === 'izin') <span class="badge-count two" style="background:#fef3c7; color:#d97706; font-size: 0.8rem; padding: 0.25rem 0.6rem;">Izin</span>
                        @elseif($a->status === 'sakit') <span class="badge-count two" style="background:#fee2e2; color:#b91c1c; font-size: 0.8rem; padding: 0.25rem 0.6rem;">Sakit</span>
                        @else <span class="badge-count zero" style="font-size: 0.8rem; padding: 0.25rem 0.6rem;">Alpa</span>
                        @endif
                    </td>
                    <td>
                        @if($a->logbook)
                            <div style="font-size: 0.85rem; color: #1e293b; line-height: 1.4; white-space: pre-line;">{{ Str::limit($a->logbook, 120) }}</div>
                        @endif
                        @if($a->keterangan)
                            <small style="color: #64748b; font-size: 0.8rem; display: block; font-style: italic;">Ket: {{ $a->keterangan }}</small>
                        @endif
                        @if(!$a->logbook && !$a->keterangan)
                            <span style="color: #94a3b8; font-size: 0.8rem;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($a->foto_kegiatan)
                            <button type="button" onclick="showImageModal('{{ asset('storage/' . $a->foto_kegiatan) }}', 'Dokumentasi {{ $a->peserta?->nama }} ({{ $a->tanggal?->format('d/m/Y') }})')" style="background: none; border: none; padding: 0; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem; color: #0284c7; font-size: 0.8rem; font-weight: 600;">
                                <img src="{{ asset('storage/' . $a->foto_kegiatan) }}" alt="Thumb" style="width: 32px; height: 32px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                                <span>Lihat</span>
                            </button>
                        @else
                            <span style="color: #94a3b8; font-size: 0.8rem;">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="{{ route('pembimbing.absensi.edit', $a) }}" class="edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('pembimbing.absensi.destroy', $a) }}" method="POST" style="display: inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada data absensi.</td>
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

<!-- Modal Popup Lihat Foto Dokumentasi -->
<div id="image-modal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1.5rem;" onclick="closeImageModal()">
    <div style="background: #ffffff; border-radius: 18px; max-width: 650px; width: 100%; max-height: 90vh; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); display: flex; flex-direction: column;" onclick="event.stopPropagation()">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h4 id="modal-title" style="margin: 0; font-size: 1rem; font-weight: 700; color: #0f172a;"><i class="fas fa-camera text-primary mr-1"></i> Foto Dokumentasi Kegiatan</h4>
            <button type="button" onclick="closeImageModal()" style="background: none; border: none; font-size: 1.25rem; color: #64748b; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <div style="padding: 1rem; overflow-y: auto; text-align: center; background: #f8fafc;">
            <img id="modal-image" src="" alt="Dokumentasi Full" style="max-width: 100%; max-height: 65vh; border-radius: 10px; object-fit: contain; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        </div>
        <div style="padding: 0.75rem 1.25rem; border-top: 1px solid #e2e8f0; text-align: right; background: #ffffff;">
            <button type="button" onclick="closeImageModal()" class="action-button" style="background: #64748b; padding: 0.4rem 1.2rem; font-size: 0.85rem; box-shadow: none;">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showImageModal(src, title) {
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-image');
        const modalTitle = document.getElementById('modal-title');
        
        modalImg.src = src;
        if (title) modalTitle.innerHTML = '<i class="fas fa-camera text-primary mr-1"></i> ' + title;
        modal.style.display = 'flex';
    }

    function closeImageModal() {
        const modal = document.getElementById('image-modal');
        modal.style.display = 'none';
    }
</script>
@endpush
@endsection
