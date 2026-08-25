<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAG-DISDIKPROV SUMSEL — Sistem Informasi Magang Dinas Pendidikan Sumatera Selatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body class="font-sans antialiased text-gray-800 bg-white">

    <!-- ===== NAVBAR ===== -->
    <header id="navbar" class="fixed w-full top-0 z-50">
        <div class="w-full px-4 sm:px-6 lg:px-12">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/logo.jpeg') }}" class="w-full h-full object-cover rounded-full" alt="Logo">
                    </div>
                    <div class="leading-tight">
                        <span class="logo-text font-bold text-base">SIMAG-DISDIKPROV<span class="logo-accent text-accent"> SUMSEL</span></span>
                        <div class="logo-text text-xs opacity-80 hidden sm:block" style="font-size:10px">Sistem Informasi Magang Dinas Pendidikan Sumatera Selatan</div>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('landing') }}" class="nav-link text-sm font-medium">Beranda</a>
                    <a href="#tentang" class="nav-link text-sm font-medium">Tentang</a>
                    <a href="#alur" class="nav-link text-sm font-medium">Alur Magang</a>
                    <a href="{{ route('pengajuan.form') }}" class="nav-link text-sm font-medium">Ajukan Magang</a>
                    <a href="{{ route('status.form') }}" class="nav-link text-sm font-medium">Cek Status</a>
                    <a href="{{ route('login') }}" class="nav-btn text-sm font-semibold px-5 py-2 rounded-lg">
                        <i class="fas fa-sign-in-alt mr-1"></i> Login Portal
                    </a>
                </nav>

                <!-- Mobile Toggle -->
                <button id="mobile-toggle" class="lg:hidden nav-link focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu Overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden opacity-0 transition-opacity duration-300"></div>

        <!-- Mobile Menu Sidebar -->
        <div id="mobile-menu" class="fixed top-0 right-0 h-full w-64 bg-navy shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col">
            <div class="p-4 flex justify-between items-center border-b border-white/10">
                <span class="text-white font-bold text-lg">Menu</span>
                <button id="mobile-close" class="text-white hover:text-accent focus:outline-none transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="px-4 py-2 space-y-1 overflow-y-auto flex-1">
                <a href="{{ route('landing') }}" class="block text-white text-sm py-3 border-b border-white/10">Beranda</a>
                <a href="#tentang" class="block text-white text-sm py-3 border-b border-white/10">Tentang</a>
                <a href="#alur" class="block text-white text-sm py-3 border-b border-white/10">Alur Magang</a>
                <a href="{{ route('pengajuan.form') }}" class="block text-white text-sm py-3 border-b border-white/10">Ajukan Magang</a>
                <a href="{{ route('status.form') }}" class="block text-white text-sm py-3 border-b border-white/10">Cek Status</a>
            </div>
            <div class="p-4 border-t border-white/10 mt-auto">
                <a href="{{ route('login') }}" class="block w-full text-center bg-accent hover:bg-yellow-400 text-navy text-sm font-bold py-3 rounded-lg transition shadow-lg shadow-yellow-900/20">Login Portal →</a>
            </div>
        </div>
    </header>

    <!-- ===== HERO ===== -->
    <section class="hero-bg min-h-screen flex items-center pt-16" style="background: linear-gradient(135deg, rgba(13,33,102,0.85) 0%, rgba(30,58,146,0.8) 60%, rgba(26,82,118,0.85) 100%), url('{{ asset('images/herosection.jpeg') }}') center/cover no-repeat;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 w-full relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Teks Hero -->
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/10 text-white text-xs font-medium px-4 py-1.5 rounded-full mb-6 border border-white/20">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Penerimaan Magang Dibuka
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                        <span class="text-white">Program Magang</span><br>
                        <span style="color:#F9DC5C">Profesional & Terstruktur</span>
                    </h1>
                    <p class="text-blue-200 text-base leading-relaxed mb-8 max-w-lg">
                        Kembangkan kompetensi Anda melalui program magang yang terdigitalisasi, didampingi pembimbing berpengalaman, dan tersertifikasi resmi.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('pengajuan.form') }}"
                            class="bg-accent text-navy font-bold px-7 py-3 rounded-lg text-sm transition hover:bg-yellow-400 shadow-lg shadow-yellow-900/30">
                            <i class="fas fa-file-alt mr-2"></i>Ajukan Magang
                        </a>
                        <a href="{{ route('login') }}"
                            class="bg-white/15 hover:bg-white/25 text-white border border-white/30 font-semibold px-7 py-3 rounded-lg text-sm transition backdrop-blur-sm">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login Portal
                        </a>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 text-center">
                        <div class="text-4xl font-extrabold text-accent mb-1">50+</div>
                        <div class="text-blue-200 text-sm">Peserta Aktif</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 text-center">
                        <div class="text-4xl font-extrabold text-accent mb-1">12+</div>
                        <div class="text-blue-200 text-sm">Bidang Tersedia</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 text-center">
                        <div class="text-4xl font-extrabold text-accent mb-1">100%</div>
                        <div class="text-blue-200 text-sm">Tersertifikasi</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 text-center">
                        <div class="text-4xl font-extrabold text-accent mb-1">1-6</div>
                        <div class="text-blue-200 text-sm">Bulan Fleksibel</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TICKER PENGUMUMAN ===== -->
    <div class="bg-navy py-2.5">
        <div class="max-w-6xl mx-auto px-4 flex items-center gap-4">
            <span class="bg-accent text-navy text-xs font-bold px-3 py-1 rounded flex-shrink-0">PENGUMUMAN</span>
            <div class="ticker-wrap flex-1 overflow-hidden">
                <span class="ticker-content text-white text-sm">
                    ✦ Penerimaan peserta magang dibuka setiap bulan &nbsp;&nbsp;&nbsp;
                    ✦ Proses verifikasi pengajuan 3–5 hari kerja &nbsp;&nbsp;&nbsp;
                    ✦ Peserta yang diterima akan mendapatkan akun portal magang &nbsp;&nbsp;&nbsp;
                    ✦ Hubungi kami untuk informasi lebih lanjut &nbsp;&nbsp;&nbsp;
                </span>
            </div>
        </div>
    </div>

    <!-- ===== TENTANG / FITUR ===== -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="fade-in">
                <h2 class="section-title">Program Magang</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6 fade-in">
                <div class="card-hover bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-navy/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chalkboard-teacher text-navy text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Pembimbing Profesional</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Setiap peserta didampingi pembimbing berpengalaman yang aktif di bidangnya.</p>
                </div>
                <div class="card-hover bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-navy/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-check text-navy text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Absensi Digital</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Rekap kehadiran peserta dikelola digital dan dapat dipantau kapan saja.</p>
                </div>
                <div class="card-hover bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-navy/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-award text-navy text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Sertifikat Resmi</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Peserta yang lulus mendapatkan sertifikat magang resmi bernilai tinggi.</p>
                </div>
                <div class="card-hover bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-navy/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-laptop-code text-navy text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Portal Terintegrasi</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pantau status, absensi, penilaian, dan sertifikat dalam satu portal.</p>
                </div>
                <div class="card-hover bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-navy/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-users-cog text-navy text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Multi Bidang</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Tersedia berbagai bidang penempatan sesuai jurusan dan minat peserta.</p>
                </div>
                <div class="card-hover bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-navy/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-clock text-navy text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Durasi Fleksibel</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Program magang tersedia mulai 1–6 bulan sesuai kebutuhan instansi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PERSYARATAN + INFORMASI PENTING ===== -->
    <section id="persyaratan" class="py-20" style="background: linear-gradient(to bottom, #e0fcff, #f8fbff);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-5 gap-10">
                <!-- Persyaratan (featured, span 3) -->
                <div class="lg:col-span-3 fade-in">
                    <h2 class="section-title">Berkas & Persyaratan Pengajuan</h2>
                    <p class="text-gray-600 text-sm mb-4">Pihak sekolah/kampus mengajukan permohonan magang kepada <strong>Dinas Pendidikan Provinsi Sumatera Selatan</strong> dengan mengunggah <strong>Surat Pengantar</strong> yang wajib memuat:</p>
                    <ul class="space-y-3">
                        @foreach([
                            ['Daftar Nama & Jumlah Peserta Magang', 'Data lengkap peserta dari sekolah / perguruan tinggi'],
                            ['NIM / NIS Peserta', 'Nomor Induk Mahasiswa / Nomor Induk Siswa aktif'],
                            ['Nomor Kontak Aktif', 'Nomor telepon/HP PIC atau peserta yang dapat dihubungi'],
                            ['Jadwal Pelaksanaan Magang', 'Tanggal pasti mulai dan selesai magang'],
                            ['File Daftar Peserta (Excel)', 'Rekapitulasi berkas peserta berformat .xlsx / .xls'],
                        ] as $req)
                        <li class="info-card flex items-start gap-3 py-3">
                            <i class="fas fa-bullhorn text-navy mt-0.5 flex-shrink-0"></i>
                            <div>
                                <div class="font-medium text-gray-800 text-sm">{{ $req[0] }}</div>
                                <div class="text-gray-500 text-xs mt-0.5" style="color:#56748F">{{ $req[1] }}</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('pengajuan.form') }}"
                        class="inline-flex items-center gap-2 mt-6 bg-navy hover:bg-navy-light text-white font-semibold px-6 py-3 rounded-lg text-sm transition shadow-md">
                        <i class="fas fa-paper-plane"></i> Isi Formulir Pengajuan
                    </a>
                </div>

                <!-- Informasi Penting (sidebar, span 2) -->
                <div class="lg:col-span-2 fade-in">
                    <h2 class="section-title">Proses & Ketentuan</h2>
                    <ul class="space-y-3">
                        @foreach([
                            ['Verifikasi berkoordinasi dengan Kasubbag Umum dan Kepegawaian'],
                            ['Pertimbangan diterima berdasarkan kesesuaian jurusan peserta'],
                            ['Peserta dengan jurusan tidak sesuai dialihkan/disarankan ke instansi yang relevan'],
                            ['Hari pertama diawali Pembinaan oleh Kasubbag Umum & Kepegawaian'],
                            ['Atasan bidang menentukan Pembimbing berdasarkan tugas yang diberikan'],
                            ['Sertifikat diterbitkan Admin setelah rekap penilaian disetujui Kasubbag'],
                        ] as $info)
                        <li class="info-card flex items-center gap-3 py-3">
                            <span class="w-2 h-2 bg-navy rounded-full flex-shrink-0"></span>
                            <span class="text-gray-700 text-sm">{{ $info[0] }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('status.form') }}"
                        class="inline-flex items-center gap-2 mt-6 border border-navy text-navy hover:bg-navy hover:text-white font-semibold px-6 py-3 rounded-lg text-sm transition">
                        <i class="fas fa-search"></i> Cek Status Pengajuan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ALUR MAGANG ===== -->
    <section id="alur" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="fade-in text-center mb-12">
                <h2 class="section-title inline-block">Alur Resmi Program Magang</h2>
                <p class="text-gray-500 text-sm mt-2">Dinas Pendidikan Provinsi Sumatera Selatan</p>
            </div>
            <div class="grid md:grid-cols-4 gap-6 fade-in">
                @foreach([
                    ['01','fa-file-alt','1. Pengajuan Berkas','Sekolah/kampus mengunggah surat pengantar memuat daftar nama, NIM/NIS, nomor kontak, & jadwal magang.'],
                    ['02','fa-user-check','2. Verifikasi Kasubbag','Admin & Kasubbag Umum Kepegawaian meninjau kesesuaian jurusan. Diterbitkan surat balasan atau arahan pengalihan instansi.'],
                    ['03','fa-chalkboard-teacher','3. Pembinaan & Penempatan','Hari pertama ikuti pembinaan Kasubbag Umum Kepegawaian. Atasan bidang menentukan pembimbing sesuai tugas.'],
                    ['04','fa-award','4. Penilaian & Sertifikat','Pembimbing menilai kinerja di bidang. Rekap disampaikan ke Kasubbag, lalu admin menerbitkan Sertifikat Magang.'],
                ] as $step)
                <div class="card-hover text-center bg-gray-50 rounded-xl p-6 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-navy rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md shadow-navy/30">
                            <i class="fas {{ $step[1] }} text-white text-xl"></i>
                        </div>
                        <div class="text-xs font-bold text-navy mb-1 tracking-wider">TAHAP {{ $step[0] }}</div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm">{{ $step[2] }}</h3>
                        <p class="text-gray-500 text-xs leading-relaxed">{{ $step[3] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===== CTA BANNER ===== -->
    <section class="py-16 bg-navy">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Siap Memulai Program Magang?</h2>
            <p class="text-blue-200 mb-8 text-sm">Ajukan sekarang dan bergabung dengan program magang terstruktur kami.</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('pengajuan.form') }}"
                    class="bg-accent text-navy font-bold px-8 py-3 rounded-lg text-sm transition hover:bg-yellow-400">
                    <i class="fas fa-rocket mr-2"></i>Ajukan Magang Sekarang
                </a>
                <a href="{{ route('status.form') }}"
                    class="bg-white/15 hover:bg-white/25 text-white border border-white/30 font-semibold px-8 py-3 rounded-lg text-sm transition">
                    <i class="fas fa-search mr-2"></i>Cek Status Pengajuan
                </a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer style="background-color:#20A4B0;">
        <div class="max-w-6xl mx-auto px-4 py-10">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Kolom 1: About -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-accent rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-navy text-lg"></i>
                        </div>
                        <span class="text-white font-bold text-lg">SIMAG-DISDIKPROV<span class="text-accent"> SUMSEL</span></span>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed mb-4">
                        Sistem Informasi Magang Dinas Pendidikan Sumatera Selatan — platform digital resmi untuk mengelola pendaftaran, penempatan, absensi, dan sertifikasi program magang secara terintegrasi.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-white/80 text-sm">
                            <i class="fas fa-map-marker-alt w-4"></i>
                            <span>Jalan Kapten A. Rivai No. 47 Palembang, Sumatera Selatan</span>
                        </div>
                        <div class="flex items-center gap-2 text-white/80 text-sm">
                            <i class="fas fa-envelope w-4"></i>
                            <span>disdiksumselprov47@gmail.com</span>
                        </div>
                        <div class="flex items-center gap-2 text-white/80 text-sm">
                            <i class="fas fa-phone w-4"></i>
                            <span>(0711) 354137</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2: Layanan -->
                <div>
                    <h6 class="text-white font-bold text-sm mb-4 uppercase tracking-wider">Layanan</h6>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pengajuan.form') }}" class="text-white/80 text-sm hover-glow transition">Ajukan Magang</a></li>
                        <li><a href="{{ route('status.form') }}" class="text-white/80 text-sm hover-glow transition">Cek Status Pengajuan</a></li>
                        <li><a href="{{ route('login') }}" class="text-white/80 text-sm hover-glow transition">Login Portal Peserta</a></li>
                        <li><a href="{{ route('login') }}" class="text-white/80 text-sm hover-glow transition">Login Portal Pembimbing</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Informasi -->
                <div>
                    <h6 class="text-white font-bold text-sm mb-4 uppercase tracking-wider">Informasi</h6>
                    <ul class="space-y-2">
                        <li><a href="#tentang" class="text-white/80 text-sm hover-glow transition">Tentang Program</a></li>
                        <li><a href="#persyaratan" class="text-white/80 text-sm hover-glow transition">Persyaratan</a></li>
                        <li><a href="#alur" class="text-white/80 text-sm hover-glow transition">Alur Magang</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/20 mt-8 pt-6 text-center">
                <p class="text-white/60 text-xs">&copy; {{ date('Y') }} SIMAG-DISDIKPROV SUMSEL. Sistem Informasi Magang Dinas Pendidikan Sumatera Selatan.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}" defer></script>
</body>
</html>
