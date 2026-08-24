@extends('layouts.adminlte')
@section('title', 'Presensi & Logbook Harian')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-calendar-check"></i> Presensi & Logbook Harian Magang</h1>
        <p>Catat kehadiran, isi kegiatan harian (logbook), dan unggah foto dokumentasi aktivitas magang Anda.</p>
    </div>
</div>

<!-- Kartu Presensi & Logbook Hari Ini -->
<div class="table-container mb-4" style="border: 2px solid {{ $sudahAbsenHariIni ? '#86efac' : '#38bdf8' }}; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); overflow: hidden;">
    <div class="table-toolbar" style="background: {{ $sudahAbsenHariIni ? 'linear-gradient(to right, #f0fdf4, #dcfce7)' : 'linear-gradient(to right, #f0f9ff, #e0f2fe)' }}; padding: 1.25rem 1.5rem; border-bottom: 1px solid {{ $sudahAbsenHariIni ? '#bbf7d0' : '#bae6fd' }};">
        <h3 style="margin: 0; color: #0f172a; font-size: 1.15rem; display: flex; align-items: center; gap: 0.6rem;">
            <i class="fas {{ $sudahAbsenHariIni ? 'fa-check-circle text-success' : 'fa-pen-to-square text-primary' }}" style="font-size: 1.3rem;"></i>
            Presensi & Logbook — {{ now()->translatedFormat('l, d F Y') }}
        </h3>
    </div>
    
    <div style="padding: 1.75rem;">
        @if($sudahAbsenHariIni)
            <!-- Tampilan Jika Sudah Melakukan Absensi Hari Ini -->
            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem; border-bottom: 1px dashed #cbd5e1; padding-bottom: 1rem;">
                    <div>
                        <span style="font-size: 0.85rem; color: #64748b; display: block; margin-bottom: 0.25rem;">Status Kehadiran Hari Ini:</span>
                        @if($sudahAbsenHariIni->status === 'hadir')
                            <span class="badge-count" style="font-size: 1rem; padding: 0.4rem 1.2rem; background: #dcfce7; color: #15803d; border: 1px solid #86efac; border-radius: 30px;">
                                <i class="fas fa-check-circle mr-1"></i> HADIR
                            </span>
                        @elseif($sudahAbsenHariIni->status === 'izin')
                            <span class="badge-count two" style="font-size: 1rem; padding: 0.4rem 1.2rem; background: #fef3c7; color: #d97706; border: 1px solid #fde68a; border-radius: 30px;">
                                <i class="fas fa-info-circle mr-1"></i> IZIN
                            </span>
                        @elseif($sudahAbsenHariIni->status === 'sakit')
                            <span class="badge-count two" style="font-size: 1rem; padding: 0.4rem 1.2rem; background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; border-radius: 30px;">
                                <i class="fas fa-notes-medical mr-1"></i> SAKIT
                            </span>
                        @endif
                        
                        @if($sudahAbsenHariIni->keterangan)
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #475569;">
                                <strong>Keterangan:</strong> {{ $sudahAbsenHariIni->keterangan }}
                            </p>
                        @endif
                    </div>
                    
                    <button type="button" onclick="toggleEditLogbook()" class="action-button" style="background: #0284c7; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 10px; box-shadow: none;">
                        <i class="fas fa-edit"></i> Perbarui Logbook / Foto
                    </button>
                </div>

                <!-- Bagian Logbook & Foto yang sudah diinput -->
                <div style="display: grid; grid-template-columns: {{ $sudahAbsenHariIni->foto_kegiatan ? '2fr 1fr' : '1fr' }}; gap: 1.5rem; align-items: start;">
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 0.6rem; display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fas fa-book-open text-primary"></i> Catatan Logbook Aktivitas:
                        </h4>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; color: #334155; font-size: 0.925rem; line-height: 1.6; min-height: 90px; white-space: pre-line;">
                            {{ $sudahAbsenHariIni->logbook ?: 'Belum ada catatan logbook yang diisi untuk hari ini. Klik "Perbarui Logbook / Foto" untuk menambahkan rincian kegiatan Anda.' }}
                        </div>
                    </div>

                    @if($sudahAbsenHariIni->foto_kegiatan)
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 0.6rem; display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fas fa-camera text-primary"></i> Dokumentasi Foto:
                        </h4>
                        <div style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1; max-width: 220px; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.05);" onclick="showImageModal('{{ asset('storage/' . $sudahAbsenHariIni->foto_kegiatan) }}', 'Dokumentasi {{ now()->translatedFormat('d F Y') }}')">
                            <img src="{{ asset('storage/' . $sudahAbsenHariIni->foto_kegiatan) }}" alt="Foto Kegiatan" style="width: 100%; height: 130px; object-fit: cover; display: block; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(15,23,42,0.7); color: white; font-size: 0.75rem; text-align: center; padding: 0.3rem;">
                                <i class="fas fa-search-plus"></i> Klik untuk memperbesar
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Form Update Logbook & Foto (Toggled) -->
                <div id="form-edit-logbook-container" style="display: none; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #e2e8f0;">
                    <form action="{{ route('peserta.absensi.logbook') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <h4 style="font-size: 0.95rem; font-weight: 700; color: #0284c7; margin-bottom: 1rem;">
                            <i class="fas fa-pen-nib mr-1"></i> Form Update Logbook Kegiatan & Unggah Foto
                        </h4>

                        <div style="margin-bottom: 1rem;">
                            <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">
                                Isi / Perbarui Logbook Kegiatan:
                            </label>
                            <textarea name="logbook" rows="4" class="form-control" style="border-radius: 12px; border-color: #94a3b8; font-size: 0.9rem; padding: 0.75rem; width: 100%;" placeholder="Tuliskan detail pekerjaan, analisis, tugas, atau pembelajaran yang dikerjakan hari ini...">{{ old('logbook', $sudahAbsenHariIni->logbook) }}</textarea>
                        </div>

                        <div style="margin-bottom: 1.25rem;">
                            <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">
                                Unggah / Ganti Foto Dokumentasi Kegiatan (Maks 5MB, format JPG/PNG):
                            </label>
                            <input type="file" name="foto_kegiatan" accept="image/*" class="form-control" style="border-radius: 12px; padding: 0.5rem;" onchange="previewImage(this, 'preview-edit-logbook')">
                            <div id="preview-edit-logbook" style="display: none; margin-top: 0.75rem;">
                                <img src="" alt="Preview" style="max-height: 140px; border-radius: 8px; border: 1px solid #cbd5e1;">
                            </div>
                        </div>

                        <div style="display: flex; gap: 0.75rem;">
                            <button type="submit" class="action-button" style="background: #16a34a; border: none; padding: 0.6rem 1.4rem; font-size: 0.9rem;">
                                <i class="fas fa-save"></i> Simpan Pembaruan Logbook
                            </button>
                            <button type="button" onclick="toggleEditLogbook()" class="action-button" style="background: #94a3b8; box-shadow: none; padding: 0.6rem 1rem; font-size: 0.9rem;">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Form Input Presensi Pertama Kali Hari Ini -->
            <form action="{{ route('peserta.absensi.self') }}" method="POST" enctype="multipart/form-data" id="form-absen">
                @csrf
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 1.25rem;">
                    <!-- Status Kehadiran -->
                    <div>
                        <label style="font-weight: 700; font-size: 0.9rem; color: #1e293b; margin-bottom: 0.5rem; display: block;">
                            Status Kehadiran <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="select-status" class="form-control" required onchange="handleStatusChange(this.value)" style="border-radius: 12px; padding: 0.75rem 1rem; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 0.95rem;">
                            <option value="hadir">✅ Hadir (Bekerja / Magang Aktif)</option>
                            <option value="izin">📋 Izin (Ada Kepentingan Resmi)</option>
                            <option value="sakit">🤒 Sakit (Tidak Dapat Hadir)</option>
                        </select>
                    </div>

                    <!-- Keterangan Izin/Sakit (Muncul Jika Izin/Sakit) -->
                    <div id="div-keterangan" style="display: none;">
                        <label style="font-weight: 700; font-size: 0.9rem; color: #1e293b; margin-bottom: 0.5rem; display: block;">
                            Keterangan / Alasan Tidak Hadir <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="keterangan" id="input-keterangan" class="form-control" placeholder="Contoh: Menghadiri sidang skripsi / sakit demam berobat..." style="border-radius: 12px; padding: 0.75rem 1rem; border: 1.5px solid #cbd5e1;">
                    </div>
                </div>

                <!-- Box Logbook Kegiatan Harian -->
                <div id="div-logbook" style="margin-bottom: 1.5rem; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.25rem;">
                    <label style="font-weight: 700; font-size: 0.95rem; color: #0f172a; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-book-bookmark text-primary"></i> 
                        Logbook Aktivitas Harian <span style="font-size: 0.8rem; font-weight: normal; color: #64748b;">(Rincian kegiatan Anda hari ini)</span>
                    </label>
                    <textarea name="logbook" id="input-logbook" rows="4" class="form-control" style="border-radius: 12px; border: 1.5px solid #cbd5e1; font-size: 0.925rem; padding: 0.85rem; line-height: 1.5; background: #ffffff;" placeholder="Tuliskan uraian tugas, kegiatan yang dilakukan, hasil pekerjaan, atau materi yang dipelajari selama magang hari ini...">{{ old('logbook') }}</textarea>
                    <small style="color: #64748b; font-size: 0.8rem; margin-top: 0.35rem; display: block;">
                        <i class="fas fa-info-circle mr-1"></i> Logbook ini akan diperiksa dan dinilai oleh Pembimbing Lapangan Anda.
                    </small>
                </div>

                <!-- Box Upload Foto Dokumentasi -->
                <div style="margin-bottom: 1.5rem; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.25rem;">
                    <label style="font-weight: 700; font-size: 0.95rem; color: #0f172a; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-image text-primary"></i> 
                        Unggah Foto Dokumentasi Kegiatan / Bukti <span style="font-size: 0.8rem; font-weight: normal; color: #64748b;">(Opsional, Maks 5MB - JPG, PNG, WEBP)</span>
                    </label>
                    <div style="display: flex; gap: 1.25rem; align-items: center; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 260px;">
                            <input type="file" name="foto_kegiatan" id="input-foto" accept="image/*" class="form-control" style="border-radius: 12px; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; background: #ffffff;" onchange="previewImage(this, 'preview-create-logbook')">
                        </div>
                        <div id="preview-create-logbook" style="display: none; position: relative;">
                            <img src="" alt="Preview Foto" style="height: 90px; width: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #38bdf8; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <span style="display: block; font-size: 0.725rem; color: #0284c7; font-weight: 600; text-align: center; margin-top: 2px;">Foto Terpilih</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="action-button" style="background: #16a34a; box-shadow: 0 6px 16px rgba(22, 163, 74, 0.25); border: none; padding: 0.85rem 2rem; border-radius: 14px; font-weight: 700; font-size: 1rem; cursor: pointer; color: white; display: flex; gap: 0.6rem; align-items: center;">
                        <i class="fas fa-paper-plane"></i> Kirim Presensi & Logbook
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<!-- Tabel Riwayat Absensi & Logbook -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-clock-rotate-left"></i> Riwayat Kehadiran & Logbook Magang</h3>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th width="120">Tanggal</th>
                    <th width="110">Status</th>
                    <th>Logbook Kegiatan</th>
                    <th width="140">Dokumentasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 700; color: #0f172a;">{{ $a->tanggal?->format('d/m/Y') }}</td>
                    <td>
                        @if($a->status === 'hadir')
                            <span class="badge-count" style="font-size: 0.8rem; padding: 0.25rem 0.7rem; background: #dcfce7; color: #15803d; border: 1px solid #86efac; border-radius: 20px;">Hadir</span>
                        @elseif($a->status === 'izin')
                            <span class="badge-count two" style="font-size: 0.8rem; padding: 0.25rem 0.7rem; background: #fef3c7; color: #d97706; border: 1px solid #fde68a; border-radius: 20px;">Izin</span>
                        @elseif($a->status === 'sakit')
                            <span class="badge-count two" style="font-size: 0.8rem; padding: 0.25rem 0.7rem; background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; border-radius: 20px;">Sakit</span>
                        @else
                            <span class="badge-count zero" style="font-size: 0.8rem; padding: 0.25rem 0.7rem; border-radius: 20px;">Alpa</span>
                        @endif
                    </td>
                    <td>
                        @if($a->logbook)
                            <div style="color: #1e293b; font-size: 0.875rem; line-height: 1.45; white-space: pre-line;">{{ $a->logbook }}</div>
                        @endif
                        @if($a->keterangan)
                            <small style="color: #64748b; display: block; margin-top: 0.25rem; font-style: italic;">
                                <strong>Keterangan:</strong> {{ $a->keterangan }}
                            </small>
                        @endif
                        @if(!$a->logbook && !$a->keterangan)
                            <span style="color: #94a3b8; font-size: 0.85rem;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($a->foto_kegiatan)
                            <button type="button" onclick="showImageModal('{{ asset('storage/' . $a->foto_kegiatan) }}', 'Dokumentasi {{ $a->tanggal?->format('d/m/Y') }}')" style="background: none; border: none; padding: 0; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; color: #0284c7; font-size: 0.85rem; font-weight: 600;">
                                <img src="{{ asset('storage/' . $a->foto_kegiatan) }}" alt="Thumbnail" style="width: 36px; height: 36px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                                <span>Lihat Foto</span>
                            </button>
                        @else
                            <span style="color: #94a3b8; font-size: 0.8rem;">Tanpa Foto</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada riwayat absensi.</td>
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
<div id="image-modal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1.5rem;" onclick="closeImageModal(event)">
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
@endsection

@push('scripts')
<script>
    function handleStatusChange(status) {
        const divKeterangan = document.getElementById('div-keterangan');
        const inputKeterangan = document.getElementById('input-keterangan');
        
        if (status === 'izin' || status === 'sakit') {
            divKeterangan.style.display = 'block';
            inputKeterangan.setAttribute('required', 'required');
        } else {
            divKeterangan.style.display = 'none';
            inputKeterangan.removeAttribute('required');
        }
    }

    function toggleEditLogbook() {
        const container = document.getElementById('form-edit-logbook-container');
        if (container.style.display === 'none' || container.style.display === '') {
            container.style.display = 'block';
            container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            container.style.display = 'none';
        }
    }

    function previewImage(input, previewElementId) {
        const previewContainer = document.getElementById(previewElementId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = previewContainer.querySelector('img');
                img.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }

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
