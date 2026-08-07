<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pengajuan — SIPADU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">

    <!-- Header -->
    <header class="bg-navy border-b-4 border-teal">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full overflow-hidden">
                    <img src="{{ asset('images/logo.jpeg') }}" class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-white font-bold text-lg">SIPA<span style="color:#F9DC5C">DU</span></span>
            </a>
            <a href="{{ route('landing') }}" class="text-white/70 hover:text-white text-sm transition">
                <i class="fas fa-arrow-left mr-1"></i> Beranda
            </a>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-16">

        <!-- Title -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-4 py-2 rounded-full mb-4">
                <i class="fas fa-search"></i> CEK STATUS PENGAJUAN
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Status Pengajuan Magang</h1>
            <p class="text-gray-500 text-sm">Masukkan email PIC yang digunakan saat mengajukan permohonan magang.</p>
        </div>

        <!-- Form Pencarian -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <form action="{{ route('status.cek') }}" method="POST">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">Email PIC <span class="text-red-500">*</span></label>
                <div class="flex gap-3">
                    <input type="email" name="email" value="{{ old('email', $email ?? '') }}" required
                        placeholder="email@instansi.com"
                        class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl transition text-sm whitespace-nowrap">
                        <i class="fas fa-search mr-1"></i> Cek Status
                    </button>
                </div>
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </form>
        </div>

        <!-- Hasil Pencarian -->
        @isset($pengajuans)
            @if($pengajuans->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
                    <i class="fas fa-inbox text-amber-400 text-3xl mb-3"></i>
                    <h3 class="font-semibold text-amber-800 mb-1">Tidak Ditemukan</h3>
                    <p class="text-amber-700 text-sm">Tidak ada pengajuan yang terdaftar dengan email <strong>{{ $email }}</strong>.</p>
                    <p class="text-amber-600 text-xs mt-2">Pastikan email yang dimasukkan sama persis dengan yang digunakan saat pengajuan.</p>
                </div>
            @else
                <div class="space-y-4">
                    <h2 class="font-semibold text-gray-700 text-sm">
                        Ditemukan <strong>{{ $pengajuans->count() }}</strong> pengajuan untuk email <span class="text-blue-600">{{ $email }}</span>:
                    </h2>
                    @foreach($pengajuans as $p)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Status Header -->
                        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between
                            {{ $p->status === 'approved' ? 'bg-emerald-50' : ($p->status === 'rejected' ? 'bg-red-50' : 'bg-amber-50') }}">
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status Pengajuan #{{ $p->id }}</span>
                                <h3 class="font-bold text-gray-900 text-lg mt-0.5">{{ $p->nama_instansi }}</h3>
                            </div>
                            <div>
                                @if($p->status === 'approved')
                                    <span class="inline-flex items-center gap-2 bg-emerald-600 text-white text-sm font-semibold px-4 py-2 rounded-full">
                                        <i class="fas fa-check-circle"></i> DISETUJUI
                                    </span>
                                @elseif($p->status === 'rejected')
                                    <span class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-full">
                                        <i class="fas fa-times-circle"></i> DITOLAK
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 bg-amber-500 text-white text-sm font-semibold px-4 py-2 rounded-full">
                                        <i class="fas fa-clock"></i> MENUNGGU
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Detail -->
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-400 text-xs uppercase tracking-wide">PIC</span>
                                    <p class="font-medium text-gray-800 mt-0.5">{{ $p->pic_nama }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs uppercase tracking-wide">Jumlah Peserta</span>
                                    <p class="font-medium text-gray-800 mt-0.5">{{ $p->jml_peserta }} orang</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs uppercase tracking-wide">Tanggal Mulai</span>
                                    <p class="font-medium text-gray-800 mt-0.5">{{ $p->tgl_mulai?->format('d F Y') ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs uppercase tracking-wide">Tanggal Selesai</span>
                                    <p class="font-medium text-gray-800 mt-0.5">{{ $p->tgl_selesai?->format('d F Y') ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs uppercase tracking-wide">Tanggal Pengajuan</span>
                                    <p class="font-medium text-gray-800 mt-0.5">{{ $p->created_at?->format('d F Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs uppercase tracking-wide">Terakhir Diperbarui</span>
                                    <p class="font-medium text-gray-800 mt-0.5">{{ $p->updated_at?->format('d F Y, H:i') }}</p>
                                </div>
                            </div>

                            @if($p->status === 'approved')
                            <div class="mt-4 bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                                <p class="text-emerald-800 text-sm font-medium">
                                    <i class="fas fa-check-circle text-emerald-500 mr-1"></i>
                                    Pengajuan Anda telah <strong>disetujui</strong> oleh Dinas Pendidikan Provinsi Sumatera Selatan setelah koordinasi dengan Kasubbag Umum dan Kepegawaian (Jurusan Sesuai). Surat balasan telah diterbitkan.
                                </p>
                                <div class="mt-2 text-emerald-700 text-xs bg-emerald-100/60 p-2.5 rounded-lg border border-emerald-200">
                                    <strong><i class="fas fa-info-circle mr-1"></i> Petunjuk Hari Pertama:</strong> Peserta wajib mengikuti <strong>pembinaan oleh Kasubbag Umum dan Kepegawaian</strong> sebelum penempatan bidang dan pembagian pembimbing oleh atasan bidang.
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('pengajuan.surat_balasan', $p) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-4 py-2 rounded-lg transition shadow-sm">
                                        <i class="fas fa-file-pdf"></i> Unduh Surat Balasan Resmi (PDF)
                                    </a>
                                </div>
                            </div>
                            @elseif($p->status === 'rejected')
                            <div class="mt-4 bg-red-50 border border-red-100 rounded-xl p-4">
                                <p class="text-red-800 text-sm font-medium mb-1">
                                    <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                    Pengajuan Anda <strong>tidak dapat diterima di Dinas Pendidikan</strong> karena ketidaksesuaian jurusan dengan kebutuhan dinas.
                                </p>
                                @if($p->keterangan_reject)
                                <p class="text-red-700 text-sm mt-1"><strong>Alasan / Pertimbangan:</strong> {{ $p->keterangan_reject }}</p>
                                @endif

                                @if($p->rekomendasi_instansi)
                                <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3 text-blue-900 text-xs">
                                    <div class="font-bold flex items-center gap-1.5 text-blue-700 text-sm mb-1">
                                        <i class="fas fa-directions text-blue-600"></i> Rekomendasi Pengalihan Instansi:
                                    </div>
                                    <p>Sesuai pertimbangan bidang ilmu peserta, kami menyarankan / mengalihkan permohonan magang ke <strong>{{ $p->rekomendasi_instansi }}</strong>.</p>
                                </div>
                                @endif
                                <p class="text-red-600 text-xs mt-2">Untuk informasi lebih lanjut, silakan hubungi Kasubbag Umum & Kepegawaian / Admin Dinas Pendidikan.</p>
                            </div>
                            @else
                            <div class="mt-4 bg-amber-50 border border-amber-100 rounded-xl p-4">
                                <p class="text-amber-800 text-sm">
                                    <i class="fas fa-clock text-amber-500 mr-1"></i>
                                    Surat permohonan telah diterima Admin dan sedang dalam proses <strong>koordinasi & verifikasi kesesuaian jurusan bersama Kasubbag Umum dan Kepegawaian</strong> (Estimasi 3–5 hari kerja).
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        @endisset

    </main>

    <footer class="border-t border-gray-100 py-6 text-center text-gray-400 text-sm mt-8">
        &copy; {{ date('Y') }} SIPADU. Semua hak dilindungi.
    </footer>

</body>
</html>
