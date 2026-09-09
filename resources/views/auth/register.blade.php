<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMAG-DISDIKPROV SUMSEL · Registrasi Peserta Magang</title>
    <!-- Preload DNS & Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    <!-- Load Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        .register-container {
            background: white;
            border-radius: 32px;
            padding: 2.5rem 3rem;
            max-width: 820px;
            width: 100%;
            box-shadow: 0 25px 60px -15px rgba(0, 20, 30, 0.25), 0 4px 18px rgba(0, 0, 0, 0.04);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            margin: 2rem auto;
            transition: all 0.3s ease;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.75rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-header .step-badge {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.88rem;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
        }

        .section-header h2 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem 1.25rem;
        }

        @media (max-width: 768px) {
            .register-container {
                padding: 1.75rem 1.5rem;
                border-radius: 24px;
            }
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .upload-card {
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            padding: 1rem 1.25rem;
            background: #f8fafc;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .upload-card:hover {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .upload-card input[type="file"] {
            font-size: 0.85rem;
            color: #475569;
            cursor: pointer;
        }

        .upload-card .upload-hint {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .select-field {
            width: 100%;
            padding: 0.85rem 1.2rem;
            border: 1.5px solid #e9edf2;
            border-radius: 14px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            background: #fafcff;
            transition: all 0.2s ease;
            color: #0f172a;
            outline: none;
            cursor: pointer;
        }

        .select-field:focus {
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
        }

        .info-pill {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 16px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-top: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .info-pill i {
            color: #2563eb;
            font-size: 1.15rem;
            margin-top: 0.15rem;
        }

        .info-pill-content {
            font-size: 0.86rem;
            color: #1e40af;
            line-height: 1.5;
        }

        .info-pill-content strong {
            color: #1e3a8a;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <!-- Logo & Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div class="logo-area" style="margin-bottom: 0;">
                <div class="logo-icon" style="background:transparent; box-shadow:none; padding:0; width:50px; height:50px;">
                    <img src="{{ asset('images/logo.jpeg') }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;" alt="Logo">
                </div>
                <div class="logo-text" style="font-size: 1.45rem;">SIMAG-DISDIKPROV<span>SUMSEL</span></div>
            </div>
            <a href="{{ route('landing') }}" style="color: #64748b; font-size: 0.85rem; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; font-weight: 500;">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <!-- Title -->
        <div class="login-title" style="margin-top: 1.25rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: #0f172a;">Pendaftaran Peserta Magang Mandiri</h1>
            <p style="color: #64748b; font-size: 0.92rem; margin-top: 0.25rem;">
                Daftarkan diri Anda dan buat akun portal. Data pengajuan akan diverifikasi oleh Kasubbag Umum & Kepegawaian sebelum akun diaktifkan.
            </p>
        </div>

        <!-- Notice Banner -->
        <div class="info-pill">
            <i class="fas fa-shield-alt"></i>
            <div class="info-pill-content">
                <strong>Alur Verifikasi:</strong> Setelah mengisi pendaftaran, akun Anda akan berstatus <strong>PENDING</strong>. Kasubbag akan meninjau berkas permohonan Anda. Setelah disetujui, Anda dapat login ke sistem dan surat balasan (LoA resmi) akan otomatis diterbitkan serta dikirimkan ke <strong>WhatsApp & Email</strong> Anda.
            </div>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="error-msg" style="margin-bottom: 1.25rem;">
                <i class="fas fa-exclamation-circle"></i>
                <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                    <strong>Terdapat kesalahan pengisian formulir:</strong>
                    <ul style="margin: 0; padding-left: 1.2rem; font-size: 0.84rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="formRegister">
            @csrf

            <!-- BAGIAN 1: DATA DIRI & AKUN LOGIN -->
            <div class="section-header">
                <div class="step-badge">1</div>
                <h2>Data Diri Peserta & Akun Login</h2>
            </div>

            <div class="form-grid-2">
                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="nama">Nama Lengkap Peserta <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Muhammad Ilham" class="{{ $errors->has('nama') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <!-- NIM / NIS / NISN -->
                <div class="form-group">
                    <label for="nim_nisn">NIM / NIS / NISN <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="nim_nisn" name="nim_nisn" value="{{ old('nim_nisn') }}" required placeholder="Nomor Induk Mahasiswa/Siswa" class="{{ $errors->has('nim_nisn') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <!-- Kategori Peserta -->
                <div class="form-group">
                    <label for="jenis_peserta">Kategori Peserta <span style="color: #dc2626;">*</span></label>
                    <select id="jenis_peserta" name="jenis_peserta" required class="select-field {{ $errors->has('jenis_peserta') ? 'invalid-input' : '' }}">
                        <option value="" disabled {{ old('jenis_peserta') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                        <option value="Mahasiswa" {{ old('jenis_peserta') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (Perguruan Tinggi)</option>
                        <option value="Siswa (SMA/SMK)" {{ old('jenis_peserta') == 'Siswa (SMA/SMK)' ? 'selected' : '' }}>Siswa (SMA / SMK / MA)</option>
                        <option value="Lainnya" {{ old('jenis_peserta') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Jurusan / Prodi -->
                <div class="form-group">
                    <label for="jurusan">Jurusan / Program Studi <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-graduation-cap"></i>
                        <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required placeholder="Contoh: Teknik Informatika / Administrasi" class="{{ $errors->has('jurusan') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <!-- Asal Sekolah / Perguruan Tinggi -->
                <div class="form-group" style="grid-column: span 2;">
                    <label for="nama_instansi">Asal Sekolah / Universitas / Politeknik <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-university"></i>
                        <input type="text" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi') }}" required placeholder="Contoh: Universitas Sriwijaya / SMKN 2 Palembang" class="{{ $errors->has('nama_instansi') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <!-- Nomor WhatsApp / HP -->
                <div class="form-group">
                    <label for="no_wa">Nomor WhatsApp / HP Aktif <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fab fa-whatsapp" style="color: #16a34a;"></i>
                        <input type="text" id="no_wa" name="no_wa" value="{{ old('no_wa') }}" required placeholder="Contoh: 083826383761" class="{{ $errors->has('no_wa') ? 'invalid-input' : '' }}" />
                    </div>
                    <small style="color: #64748b; font-size: 0.76rem; margin-top: 0.25rem; display: block;">
                        Notifikasi kelulusan & link LoA akan dikirimkan ke nomor WhatsApp ini.
                    </small>
                </div>

                <!-- Alamat Email -->
                <div class="form-group">
                    <label for="email">Alamat Email Aktif <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email.anda@gmail.com" class="{{ $errors->has('email') ? 'invalid-input' : '' }}" />
                    </div>
                    <small style="color: #64748b; font-size: 0.76rem; margin-top: 0.25rem; display: block;">
                        Digunakan untuk login ke portal dan menerima surat balasan via email.
                    </small>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Kata Sandi (Password) <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" class="{{ $errors->has('password') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirmation">Ulangi Kata Sandi <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-shield-alt"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ketik ulang kata sandi" />
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: PERIODE JADWAL MAGANG -->
            <div class="section-header">
                <div class="step-badge">2</div>
                <h2>Periode Pelaksanaan Magang</h2>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="tgl_mulai">Tanggal Mulai Magang <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required class="{{ $errors->has('tgl_mulai') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="tgl_selesai">Tanggal Selesai Magang <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-calendar-check"></i>
                        <input type="date" id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required class="{{ $errors->has('tgl_selesai') ? 'invalid-input' : '' }}" />
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: BERKAS PERSYARATAN -->
            <div class="section-header">
                <div class="step-badge">3</div>
                <h2>Upload Berkas Persyaratan (PDF, JPG, PNG — Maks. 5MB)</h2>
            </div>

            <div class="form-group">
                <label>1. Surat Pengantar / Permohonan Magang dari Kampus / Sekolah <span style="color: #dc2626;">*</span></label>
                <div class="upload-card">
                    <input type="file" name="file_surat" accept=".pdf,.jpg,.jpeg,.png" required />
                    <span class="upload-hint">Surat resmi permohonan magang bertanda tangan dan berstempel instansi asal.</span>
                </div>
            </div>

            <div class="form-group">
                <label>2. Transkrip Nilai Akademik Terakhir <span style="color: #dc2626;">*</span></label>
                <div class="upload-card">
                    <input type="file" name="file_transkrip" accept=".pdf,.jpg,.jpeg,.png" required />
                    <span class="upload-hint">Transkrip nilai / KHS kumulatif atau rapor terakhir.</span>
                </div>
            </div>

            <div class="form-group">
                <label>3. Surat Pernyataan Bersedia Mengikuti Program Magang Berdampak <span style="color: #dc2626;">*</span></label>
                <div class="upload-card">
                    <input type="file" name="file_surat_pernyataan" accept=".pdf,.jpg,.jpeg,.png" required />
                    <span class="upload-hint">Surat komitmen kesediaan mematuhi aturan dan menyelesaikan program sampai selesai.</span>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan / Catatan Tambahan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" rows="2" placeholder="Tuliskan catatan tambahan jika ada..." style="width:100%; border:1.5px solid #e9edf2; border-radius:14px; padding:0.75rem 1rem; font-family:'Inter', sans-serif; font-size:0.92rem; outline:none; transition:border-color 0.2s ease;">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 2rem;">
                <button type="submit" class="btn-login" style="padding: 1rem 1.5rem; font-size: 1rem; font-weight: 700; border-radius: 16px; display: flex; align-items: center; justify-content: center; gap: 0.6rem;">
                    <i class="fas fa-paper-plane"></i> Kirim Pendaftaran & Buat Akun
                </button>
            </div>

            <div class="signup-link" style="margin-top: 1.5rem; text-align: center;">
                Sudah memiliki akun? <a href="{{ route('login') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">Masuk ke Portal</a>
            </div>
        </form>
    </div>

</body>

</html>
