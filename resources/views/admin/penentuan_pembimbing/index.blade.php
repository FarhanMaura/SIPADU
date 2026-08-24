@extends('layouts.adminlte')
@section('title', 'Penentuan Pembimbing & Bidang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-check"></i> Penentuan Pembimbing & Bidang Penempatan</h1>
        <p><i class="fas fa-chevron-right"></i> Admin <i class="fas fa-chevron-right"></i> Penentuan Pembimbing</p>
    </div>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Peserta Magang & Penempatan Pembimbing</h3>
        <form action="{{ route('admin.penentuan_pembimbing.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peserta/instansi..." onchange="this.form.submit()" />
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Peserta</th>
                    <th>Instansi & Jurusan</th>
                    <th width="240">Bidang (Subbagian)</th>
                    <th width="260">Pembimbing Lapangan</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $peserta)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($pesertas->currentPage() - 1) * $pesertas->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong style="color: #1e293b; display: block; font-size: 0.95rem;">{{ $peserta->nama }}</strong>
                        <small style="color: #64748b;">NIM/NISN: {{ $peserta->nim_nisn ?? '-' }}</small>
                        @if($peserta->status)
                            <div>
                                <span class="badge-status {{ $peserta->status === 'aktif' ? 'approved' : 'pending' }}" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">
                                    {{ ucfirst($peserta->status) }}
                                </span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong style="color: #0f172a;">{{ $peserta->instansi->nama ?? '-' }}</strong><br>
                        <small style="color: #64748b;"><i class="fas fa-graduation-cap mr-1"></i> {{ $peserta->jurusan ?? '-' }}</small>
                    </td>
                    <form action="{{ route('admin.penentuan_pembimbing.update', $peserta) }}" method="POST">
                        @csrf @method('PATCH')
                        <td>
                            <select name="bidang_id" class="form-control select-bidang" data-peserta-id="{{ $peserta->id }}" style="border-radius: 8px; font-size: 0.85rem; padding: 0.45rem 0.6rem;" required>
                                <option value="">-- Pilih Bidang / Subbagian --</option>
                                @foreach($bidangs as $b)
                                    <option value="{{ $b->id }}" {{ $peserta->bidang_id == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                                @endforeach
                            </select>
                            <small class="bidang-info-{{ $peserta->id }}" style="font-size: 0.725rem; color: #64748b; margin-top: 0.25rem; display: block;"></small>
                        </td>
                        <td>
                            <select name="pembimbing_id" id="pembimbing-select-{{ $peserta->id }}" class="form-control select-pembimbing" data-peserta-id="{{ $peserta->id }}" data-initial-pembimbing="{{ $peserta->pembimbing_id }}" style="border-radius: 8px; font-size: 0.85rem; padding: 0.45rem 0.6rem;" required>
                                <option value="">-- Pilih Pembimbing --</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="action-button" style="background: #16a34a; padding: 0.45rem 0.85rem; font-size: 0.85rem; border: none; box-shadow: none; width: 100%; justify-content: center;">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </td>
                    </form>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-user-slash fa-2x mb-3 text-muted"></i>
                        <p class="mb-0 font-weight-bold">Belum ada data peserta magang.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span><i class="far fa-clock" style="margin-right: 6px;"></i> Terakhir diperbarui: {{ today()->translatedFormat('d F Y') }}</span>
        {{ $pesertas->links() }}
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pembimbingsData = @json($pembimbings);

    function updatePembimbingDropdown(selectBidangEl, isInitialLoad = false) {
        const pesertaId = selectBidangEl.getAttribute('data-peserta-id');
        const pembimbingSelectEl = document.getElementById('pembimbing-select-' + pesertaId);
        if (!pembimbingSelectEl) return;

        const selectedBidangId = selectBidangEl.value;
        const currentSelectedId = isInitialLoad 
            ? (pembimbingSelectEl.getAttribute('data-initial-pembimbing') || '') 
            : pembimbingSelectEl.value;

        // Kosongkan opsi sebelumnya
        pembimbingSelectEl.innerHTML = '';

        if (!selectedBidangId) {
            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = '-- Pilih Bidang Terlebih Dahulu --';
            pembimbingSelectEl.appendChild(defaultOpt);
            pembimbingSelectEl.disabled = true;
            return;
        }

        // Filter pembimbing yang memiliki bidang_id sesuai bidang yang dipilih
        const filtered = pembimbingsData.filter(function (pb) {
            return String(pb.bidang_id) === String(selectedBidangId);
        });

        pembimbingSelectEl.disabled = false;

        if (filtered.length === 0) {
            const emptyOpt = document.createElement('option');
            emptyOpt.value = '';
            emptyOpt.textContent = '-- Tidak ada pembimbing di bidang ini --';
            pembimbingSelectEl.appendChild(emptyOpt);
        } else {
            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = '-- Pilih Pembimbing (' + filtered.length + ' pembimbing tersedia) --';
            pembimbingSelectEl.appendChild(defaultOpt);

            let isFound = false;
            filtered.forEach(function (pb) {
                const opt = document.createElement('option');
                opt.value = pb.id;
                opt.textContent = pb.nama + (pb.nip ? ' (NIP: ' + pb.nip + ')' : '');
                if (String(pb.id) === String(currentSelectedId)) {
                    opt.selected = true;
                    isFound = true;
                }
                pembimbingSelectEl.appendChild(opt);
            });

            // Jika pada inisialisasi awal ID pembimbing yang sudah tersimpan ada, tandai terpilih
            if (isInitialLoad && !isFound && currentSelectedId) {
                // Pembimbing yang sebelumnya dipilih mungkin dari bidang lama
                const orphanPb = pembimbingsData.find(pb => String(pb.id) === String(currentSelectedId));
                if (orphanPb) {
                    const orphanOpt = document.createElement('option');
                    orphanOpt.value = orphanPb.id;
                    orphanOpt.textContent = orphanPb.nama + ' (Bidang Lain)';
                    orphanOpt.selected = true;
                    pembimbingSelectEl.appendChild(orphanOpt);
                }
            }
        }
    }

    // Inisialisasi setiap baris tabel pada saat halaman dimuat
    document.querySelectorAll('.select-bidang').forEach(function (selectBidangEl) {
        updatePembimbingDropdown(selectBidangEl, true);

        // Saat bidang diubah oleh user, dropdown pembimbing otomatis terfilter
        selectBidangEl.addEventListener('change', function () {
            const pesertaId = this.getAttribute('data-peserta-id');
            const pembimbingSelectEl = document.getElementById('pembimbing-select-' + pesertaId);
            if (pembimbingSelectEl) {
                pembimbingSelectEl.removeAttribute('data-initial-pembimbing');
                pembimbingSelectEl.value = '';
            }
            updatePembimbingDropdown(this, false);
        });
    });
});
</script>
@endpush
@endsection
