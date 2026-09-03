<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMAG-DISDIKPROV SUMSEL · @yield('title', 'Dashboard')</title>
    
    <!-- Preload DNS & Assets untuk mempercepat load -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    <!-- Preload Font & Styles -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style">
    <link rel="preload" href="{{ asset('css/dashboard.css') }}" as="style">
    
    <!-- Load Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>

    <!-- OVERLAY -->
    <div class="overlay" id="overlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="logo-area">
            <div class="logo-icon" style="background:transparent; box-shadow:none; padding:0;">
                <img src="{{ asset('images/logo.jpeg') }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;" alt="Logo">
            </div>
            <div class="logo-text">SIMAG-DISDIKPROV<span>SUMSEL</span></div>
        </div>

        <nav class="nav-section">
            <a href="{{ route('dashboard') }}" class="nav-item {{ Request::is('dashboard') || Request::is('*/dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>

            <!-- Role Admin Sidebar Menu -->
            @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                <div class="nav-label">MASTER DATA</div>
                <div class="nav-item {{ Request::is('admin/bidang*') || Request::is('admin/pembimbing*') || Request::is('admin/peserta*') || Request::is('admin/instansi*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> Data Master
                </div>
                <div class="sub-nav">
                    <a href="{{ route('admin.bidang.index') }}" class="nav-item {{ Request::is('admin/bidang*') ? 'active' : '' }}">
                        Bidang
                    </a>
                    <a href="{{ route('admin.pembimbing.index') }}" class="nav-item {{ Request::is('admin/pembimbing*') ? 'active' : '' }}">
                        Pembimbing
                    </a>
                    <a href="{{ route('admin.peserta.index') }}" class="nav-item {{ Request::is('admin/peserta*') || Request::is('admin/instansi*') ? 'active' : '' }}">
                        Peserta Magang
                    </a>
                </div>

                <div class="nav-label">PENEMPATAN & NILAI</div>
                <a href="{{ route('admin.penentuan_pembimbing.index') }}" class="nav-item {{ Request::is('admin/penentuan-pembimbing*') ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i> Penentuan Pembimbing
                </a>
                <a href="{{ route('admin.rekap_nilai.index') }}" class="nav-item {{ Request::is('admin/rekap-nilai*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> Rekap Nilai & Sertifikat
                </a>

                <div class="nav-label">KEAMANAN & SISTEM</div>
                <a href="{{ route('admin.user.index') }}" class="nav-item {{ Request::is('admin/user*') ? 'active' : '' }}">
                    <i class="fas fa-shield-alt"></i> Kelola User
                </a>
            @endif

            <!-- Role Kasubbag Sidebar Menu -->
            @if(auth()->user()->role === \App\Models\User::ROLE_KASUBBAG)
                <div class="nav-label">PENGAWASAN & VERIFIKASI</div>
                <a href="{{ route('kasubbag.pengajuan.index') }}" class="nav-item {{ Request::is('kasubbag/pengajuan*') ? 'active' : '' }}">
                    <i class="fas fa-file-signature"></i> Verifikasi Pengajuan
                </a>
                <a href="{{ route('kasubbag.peserta.index') }}" class="nav-item {{ Request::is('kasubbag/peserta*') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i> Penempatan Peserta
                </a>
            @endif

            <!-- Role Pembimbing Sidebar Menu -->
            @if(auth()->user()->role === \App\Models\User::ROLE_PEMBIMBING)
                <div class="nav-label">EVALUASI & ABSENSI</div>
                <a href="{{ route('pembimbing.peserta.index') }}" class="nav-item {{ Request::is('pembimbing/peserta*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Peserta Bimbingan
                </a>
                <a href="{{ route('pembimbing.absensi.index') }}" class="nav-item {{ Request::is('pembimbing/absensi*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Kelola Absensi
                </a>
                <a href="{{ route('pembimbing.penilaian.index') }}" class="nav-item {{ Request::is('pembimbing/penilaian*') ? 'active' : '' }}">
                    <i class="fas fa-award"></i> Penilaian
                </a>
            @endif

            <!-- Role Peserta Sidebar Menu -->
            @if(auth()->user()->role === \App\Models\User::ROLE_PESERTA)
                <div class="nav-label">PORTAL MAHASISWA</div>
                <a href="{{ route('peserta.status') }}" class="nav-item {{ Request::is('peserta/status*') ? 'active' : '' }}">
                    <i class="fas fa-search-location"></i> Melihat Penempatan
                </a>
                <a href="{{ route('peserta.absensi') }}" class="nav-item {{ Request::is('peserta/absensi*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Presensi / Absensi
                </a>
                <a href="{{ route('peserta.penilaian') }}" class="nav-item {{ Request::is('peserta/penilaian*') ? 'active' : '' }}">
                    <i class="fas fa-award"></i> Hasil Penilaian
                </a>
                <a href="{{ route('peserta.sertifikat') }}" class="nav-item {{ Request::is('peserta/sertifikat*') ? 'active' : '' }}">
                    <i class="fas fa-certificate"></i> Sertifikat
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                @csrf
            </form>
            <a href="#" class="nav-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-top: 1rem;">
                <i class="fas fa-sign-out-alt text-danger"></i> Logout
            </a>
        </nav>

        <div class="user-status">
            <span class="dot"></span>
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role">
                    @if(Auth::user()->role === 1) Admin
                    @elseif(Auth::user()->role === 2) Pembimbing
                    @elseif(Auth::user()->role === 4) Kasubbag Umum & Kepegawaian
                    @else Peserta
                    @endif
                </span>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- Mobile Menu Button -->
        <div class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i> Menu
        </div>

        <!-- Alert messages rendering as clean alert-toasts -->
        @if(session('success'))
            <div class="alert-toast alert-toast-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-toast alert-toast-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert-toast alert-toast-success" style="background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8;">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-toast alert-toast-danger">
                <ul style="list-style: none; padding-left: 0;">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Render Content -->
        @yield('content')

        <!-- Copyright -->
        <div class="copyright">
            <i class="far fa-copyright"></i> {{ date('Y') }} SIMAG-DISDIKPROV SUMSEL · Sistem Informasi Magang Dinas Pendidikan Sumatera Selatan.
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}" defer></script>
    @stack('scripts')
</body>

</html>
