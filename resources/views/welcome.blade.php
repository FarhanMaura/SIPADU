<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPADU — Sistem Informasi Pengelolaan Aktivitas & Data Unit Magang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>

    <nav>
        <a href="/" class="logo">
            <div style="width:40px; height:40px; overflow:hidden; border-radius:50%;">
                <img src="{{ asset('images/logo.jpeg') }}" style="width:100%; height:100%; object-fit:cover;" alt="Logo">
            </div>
            SIPA<span>DU</span>
        </a>
        <div class="nav-links">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-login"><i class="fas fa-desktop"></i> Dashboard</a>
            @else
                <a href="{{ route('pengajuan.form') }}" class="nav-link">Daftar Magang</a>
                <a href="{{ route('status.form') }}" class="nav-link">Cek Status</a>
                <a href="{{ route('login') }}" class="btn-login">Log In</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="badge"><i class="fas fa-star text-yellow-400"></i> Platform Magang Resmi Terpadu</div>
            <h1 class="hero-title">Kelola Program Magang Menjadi Lebih <span>Mudah & Efektif</span></h1>
            <p class="hero-subtitle">
                SIPADU (Sistem Informasi Pengelolaan Aktivitas & Data Unit Magang) membantu mempermudah proses pendaftaran, pemantauan, dan penilaian kegiatan magang secara digital.
            </p>
            <div class="hero-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Ke Dashboard Saya <i class="fas fa-arrow-right"></i></a>
                @else
                    <a href="{{ route('pengajuan.form') }}" class="btn-primary">Daftar Magang Sekarang</a>
                    <a href="{{ route('login') }}" class="btn-secondary">Masuk ke Akun</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <h3 class="feature-title">Pendaftaran Online</h3>
            <p class="feature-desc">Ajukan permohonan magang untuk instansi sekolah atau universitas Anda langsung melalui sistem tanpa perlu dokumen fisik.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h3 class="feature-title">Absensi Digital</h3>
            <p class="feature-desc">Peserta magang dapat melakukan pencatatan kehadiran harian secara digital langsung melalui dashboard pribadi.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <h3 class="feature-title">E-Sertifikat</h3>
            <p class="feature-desc">Setelah program magang selesai dan nilai telah diterbitkan, peserta dapat mengunduh sertifikat resmi dalam format PDF.</p>
        </div>
    </section>

</body>
</html>
