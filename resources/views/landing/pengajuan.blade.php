<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengajuan Magang — SIMAG-DISDIKPROV SUMSEL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
</head>
<body class="font-sans antialiased bg-gray-50">

    <!-- Header -->
    <header class="bg-navy">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full overflow-hidden">
                    <img src="{{ asset('images/logo.jpeg') }}" class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-white font-bold text-lg">SIMAG-DISDIKPROV<span style="color:#F9DC5C"> SUMSEL</span></span>
            </a>
            <a href="{{ route('landing') }}" class="text-white/70 hover:text-white text-sm transition">
                <i class="fas fa-arrow-left mr-1"></i> Beranda
            </a>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 py-12">
        <!-- Page Title -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-4 py-2 rounded-full mb-4">
                <i class="fas fa-user-graduate"></i> FORMULIR PENGAJUAN MAGANG MANDIRI
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Permohonan Magang Dinas Pendidikan Prov. Sumsel</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">Pengajuan permohonan magang mandiri oleh peserta didik/mahasiswa kepada Dinas Pendidikan Provinsi Sumatera Selatan. Pastikan seluruh berkas kelengkapan diunggah dengan benar.</p>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 flex items-start gap-3">
            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
            <div>
                <div class="font-semibold">Pengajuan Berhasil Dikirim!</div>
                <div class="text-sm mt-1">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6">
            <div class="font-semibold flex items-center gap-2 mb-2">
                <i class="fas fa-exclamation-circle text-red-500"></i> Ada kesalahan input:
            </div>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('pengajuan.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- BAGIAN 1: DATA PESERTA -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center font-bold">1</span>
                    Data Diri Calon Peserta Magang (Pemohon)
                </h2>
                <div class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap Peserta Magang <span class="text-red-500">*</span></label>
                            <input type="text" name="pic_nama" value="{{ old('pic_nama') }}" required placeholder="Contoh: Ahmad Rizki"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIM / NIS / NISN <span class="text-red-500">*</span></label>
                            <input type="text" name="nim_nisn" value="{{ old('nim_nisn') }}" required placeholder="Contoh: 09031282126040"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori / Jenis Peserta <span class="text-red-500">*</span></label>
                            <select name="jenis_peserta" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                                <option value="" disabled {{ old('jenis_peserta') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                <option value="Mahasiswa" {{ old('jenis_peserta') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (Perguruan Tinggi)</option>
                                <option value="Siswa (SMA/SMK)" {{ old('jenis_peserta') == 'Siswa (SMA/SMK)' ? 'selected' : '' }}>Siswa (SMA / SMK / MA)</option>
                                <option value="Lainnya" {{ old('jenis_peserta') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jurusan / Program Studi <span class="text-red-500">*</span></label>
                            <input type="text" name="jurusan" value="{{ old('jurusan') }}" required placeholder="Contoh: Teknik Informatika"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Asal Sekolah / Kampus / Instansi <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_instansi" value="{{ old('nama_instansi') }}" required placeholder="Contoh: Universitas Sriwijaya / SMKN 2 Palembang"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Peserta Magang <span class="text-red-500">*</span></label>
                            <input type="email" name="pic_email" value="{{ old('pic_email') }}" required placeholder="email.peserta@gmail.com"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="pic_telp" value="{{ old('pic_telp') }}" required placeholder="08xxxxxxxxxx"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: PERIODE JADWAL MAGANG -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center font-bold">2</span>
                    Periode Pelaksanaan Magang
                </h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: DOKUMEN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center font-bold">3</span>
                    Upload Dokumen Persyaratan
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Surat Pengantar / Permohonan Magang dari Sekolah/Kampus <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-blue-400 transition bg-blue-50/30">
                            <input type="file" name="file_surat" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG — Maks. 5MB</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Transkrip Nilai <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-blue-400 transition">
                            <input type="file" name="file_transkrip" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG — Maks. 5MB</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Surat Pernyataan Bersedia Mengikuti, Melaksanakan, dan Menyelesaikan Program Magang Berdampak Hingga Selesai <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-blue-400 transition">
                            <input type="file" name="file_surat_pernyataan" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG — Maks. 5MB</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="3" placeholder="Informasi tambahan yang perlu disampaikan..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                <i class="fas fa-paper-plane"></i> Kirim Pengajuan Magang Mandiri
            </button>
            <p class="text-center text-xs text-gray-400 mt-4">
                Dengan mengirim formulir ini, Anda menyetujui bahwa data yang diisi adalah benar.
            </p>
        </form>
    </main>

    <footer class="border-t border-gray-100 py-8 text-center text-gray-500 text-sm mt-8 bg-white">
        <div class="max-w-2xl mx-auto px-4 space-y-3">
            <div class="flex flex-wrap items-center justify-center gap-6 text-sm">
                <a href="https://www.instagram.com/disdik_provsumsel?igsi=eTU1dDJweHA2eGR5" target="_blank" class="hover:text-pink-600 transition flex items-center gap-1.5 font-medium">
                    <i class="fab fa-instagram text-base text-pink-600"></i> @disdik_provsumsel
                </a>
                <a href="https://www.youtube.com/@dinaspendidikanprovsumsel" target="_blank" class="hover:text-red-600 transition flex items-center gap-1.5 font-medium">
                    <i class="fab fa-youtube text-base text-red-600"></i> Dinas Pendidikan Sumsel
                </a>
                <a href="mailto:wardik.sumsel@gmail.com" class="hover:text-blue-600 transition flex items-center gap-1.5 font-medium">
                    <i class="fas fa-envelope text-base text-blue-600"></i> wardik.sumsel@gmail.com
                </a>
            </div>
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} SIMAG-DISDIKPROV SUMSEL. Dinas Pendidikan Provinsi Sumatera Selatan.</p>
        </div>
    </footer>
</body>
</html>
