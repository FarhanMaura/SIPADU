<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengajuan Magang — SIPADU</title>
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
                <span class="text-white font-bold text-lg">SIPA<span style="color:#F9DC5C">DU</span></span>
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
                <i class="fas fa-file-alt"></i> FORMULIR PENGAJUAN MAGANG
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Ajukan Program Magang</h1>
            <p class="text-gray-500">Isi data di bawah ini dengan lengkap dan benar. Tim kami akan menghubungi PIC dalam 3–5 hari kerja.</p>
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

            <!-- BAGIAN 1: DATA INSTANSI -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center font-bold">1</span>
                    Data Instansi / Lembaga
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Instansi / Sekolah / Kampus <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_instansi" value="{{ old('nama_instansi') }}" required placeholder="Contoh: SMK Negeri 1 Jakarta"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Peserta <span class="text-red-500">*</span></label>
                            <input type="number" name="jml_peserta" value="{{ old('jml_peserta', 1) }}" min="1" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
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
            </div>

            <!-- BAGIAN 2: DATA PIC -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center font-bold">2</span>
                    Data PIC (Person in Charge)
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama PIC <span class="text-red-500">*</span></label>
                        <input type="text" name="pic_nama" value="{{ old('pic_nama') }}" required placeholder="Nama lengkap penanggung jawab"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email PIC <span class="text-red-500">*</span></label>
                            <input type="email" name="pic_email" value="{{ old('pic_email') }}" required placeholder="email@instansi.com"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">No. HP PIC <span class="text-red-500">*</span></label>
                            <input type="text" name="pic_telp" value="{{ old('pic_telp') }}" required placeholder="08xxxxxxxxxx"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: DOKUMEN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center font-bold">3</span>
                    Upload Dokumen
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Surat Permohonan <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-blue-400 transition">
                            <input type="file" name="file_surat" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG — Maks. 5MB</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Daftar Peserta (Excel) <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-blue-400 transition">
                            <input type="file" name="file_peserta" accept=".xlsx,.xls" required class="w-full text-sm text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">Format: XLSX, XLS — Maks. 5MB</p>
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
                <i class="fas fa-paper-plane"></i> Kirim Pengajuan Magang
            </button>
            <p class="text-center text-xs text-gray-400 mt-4">
                Dengan mengirim formulir ini, Anda menyetujui bahwa data yang diisi adalah benar.
            </p>
        </form>
    </main>

    <footer class="border-t border-gray-100 py-6 text-center text-gray-400 text-sm mt-8">
        &copy; {{ date('Y') }} SIPADU. Semua hak dilindungi.
    </footer>
</body>
</html>
