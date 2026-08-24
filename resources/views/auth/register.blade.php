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
        .login-container {
            max-width: 520px;
        }

        /* Custom Searchable Dropdown Styling */
        .custom-select-container {
            position: relative;
            width: 100%;
        }

        .custom-select-trigger {
            width: 100%;
            padding: 0.85rem 2.8rem 0.85rem 2.8rem;
            border: 1.5px solid #e9edf2;
            border-radius: 14px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            background: #fafcff;
            transition: all 0.2s ease;
            color: #0f172a;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
            box-sizing: border-box;
        }

        .custom-select-trigger:hover {
            border-color: #cbd5e1;
            background: #ffffff;
        }

        .custom-select-container.open .custom-select-trigger,
        .custom-select-trigger:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
            background: #ffffff;
        }

        .custom-select-container.invalid .custom-select-trigger {
            border-color: #dc2626 !important;
            background: #fef2f2 !important;
        }

        .select-icon-left {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .custom-select-container.open .select-icon-left {
            color: #2563eb;
        }

        .select-caret-right {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
            pointer-events: none;
            transition: transform 0.25s ease, color 0.2s ease;
        }

        .custom-select-container.open .select-caret-right {
            transform: translateY(-50%) rotate(180deg);
            color: #2563eb;
        }

        .selected-text-wrap {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
            font-size: 0.92rem;
        }

        .selected-text-wrap.placeholder {
            color: #94a3b8;
        }

        /* Dropdown Panel */
        .custom-dropdown-panel {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 16px 40px -10px rgba(15, 23, 42, 0.2), 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
            z-index: 999;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .custom-select-container.open .custom-dropdown-panel {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Search input inside panel */
        .search-box-wrap {
            padding: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
            background: #f8fafc;
            position: relative;
        }

        .search-box-wrap i {
            position: absolute;
            left: 1.4rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .search-box-wrap input {
            width: 100%;
            padding: 0.55rem 0.75rem 0.55rem 2.2rem !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            font-size: 0.88rem !important;
            background: #ffffff !important;
            box-shadow: none !important;
        }

        .search-box-wrap input:focus {
            border-color: #2563eb !important;
        }

        /* Options list */
        .options-list {
            max-height: 220px;
            overflow-y: auto;
            padding: 0.35rem;
            margin: 0;
            list-style: none;
        }

        .options-list::-webkit-scrollbar {
            width: 6px;
        }

        .options-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .options-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .option-item {
            padding: 0.65rem 0.85rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            border-left: 3px solid transparent;
        }

        .option-item:hover,
        .option-item.highlighted {
            background: #eff6ff;
            border-left-color: #2563eb;
        }

        .option-item.selected {
            background: #dbeafe;
            border-left-color: #1d4ed8;
        }

        .option-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #0f172a;
        }

        .option-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #64748b;
            flex-wrap: wrap;
        }

        .badge-chip {
            background: #e2e8f0;
            color: #334155;
            padding: 0.1rem 0.45rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .badge-instansi {
            background: #dbeafe;
            color: #1e40af;
        }

        .no-results {
            padding: 1rem;
            text-align: center;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        /* Info & Warning boxes */
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            padding: 0.85rem 1rem;
            border-radius: 14px;
            font-size: 0.85rem;
            margin-top: 1rem;
            line-height: 1.4;
            display: flex;
            gap: 0.6rem;
            align-items: flex-start;
        }
        .info-box i {
            margin-top: 0.15rem;
            font-size: 1rem;
            color: #2563eb;
        }
        .warning-box {
            background: #fffbe6;
            border: 1px solid #ffe58f;
            color: #8c6b00;
            padding: 1rem;
            border-radius: 14px;
            font-size: 0.88rem;
            margin-top: 1.2rem;
            line-height: 1.5;
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
        }
        .warning-box i {
            margin-top: 0.15rem;
            font-size: 1.1rem;
            color: #faad14;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- Logo -->
        <div class="logo-area">
            <div class="logo-icon" style="background:transparent; box-shadow:none; padding:0; width:52px; height:52px;">
                <img src="{{ asset('images/logo.jpeg') }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;" alt="Logo">
            </div>
            <div class="logo-text">SIPA<span>DU</span></div>
        </div>

        <!-- Title -->
        <div class="login-title">
            <h1>Registrasi Akun Peserta</h1>
            <p>Pilih data diri Anda yang telah disetujui Kasubbag untuk membuat akun</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if($pesertas->isEmpty())
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Belum Ada Data Peserta Disetujui</strong><br>
                    Data peserta Anda belum diinput atau disetujui oleh Kasubbag. Silakan pastikan pengajuan magang Anda sudah dikonfirmasi oleh Kasubbag.
                </div>
            </div>
            <div class="signup-link" style="margin-top: 1.5rem;">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        @else
            <!-- Info Box -->
            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <div>
                    Data pada pilihan bersumber dari pengajuan magang yang telah <strong>disetujui oleh Kasubbag</strong>.
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Hidden Input for Form Submission -->
                <input type="hidden" name="peserta_id" id="peserta_id" value="{{ old('peserta_id') }}" required />

                <!-- Custom Searchable Select Component -->
                <div class="form-group">
                    <label>Pilih Data Peserta Magang <span style="color: #dc2626;">*</span></label>
                    
                    <div class="custom-select-container {{ $errors->has('peserta_id') ? 'invalid' : '' }}" id="customSelect">
                        <i class="fas fa-id-card select-icon-left"></i>
                        <div class="custom-select-trigger" tabindex="0">
                            <span class="selected-text-wrap placeholder" id="selectedText">-- Pilih Data Peserta Anda --</span>
                        </div>
                        <i class="fas fa-chevron-down select-caret-right"></i>

                        <!-- Panel Dropdown -->
                        <div class="custom-dropdown-panel">
                            <div class="search-box-wrap">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Cari nama, NIM, atau sekolah/kampus..." autocomplete="off" />
                            </div>
                            <ul class="options-list" id="optionsList">
                                @foreach($pesertas as $p)
                                    @php
                                        $instansiNama = $p->instansi?->nama ?? $p->pengajuan?->nama_instansi ?? 'Instansi N/A';
                                        $identifier = $p->nim_nisn ? $p->nim_nisn : 'Tanpa NIM/NISN';
                                        $displayText = $p->nama . ' (' . $identifier . ') - ' . $instansiNama;
                                    @endphp
                                    <li class="option-item" 
                                        data-id="{{ $p->id }}" 
                                        data-name="{{ $p->nama }}"
                                        data-nisn="{{ $identifier }}"
                                        data-instansi="{{ $instansiNama }}"
                                        data-search="{{ strtolower($p->nama . ' ' . $identifier . ' ' . $instansiNama) }}">
                                        <div class="option-name">{{ $p->nama }}</div>
                                        <div class="option-meta">
                                            <span class="badge-chip"><i class="fas fa-id-badge" style="font-size:0.7rem; margin-right:2px;"></i> {{ $identifier }}</span>
                                            <span class="badge-chip badge-instansi"><i class="fas fa-building" style="font-size:0.7rem; margin-right:2px;"></i> {{ $instansiNama }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="no-results" id="noResults" style="display: none;">
                                <i class="fas fa-search-minus" style="font-size: 1.2rem; margin-bottom: 0.3rem; display: block;"></i>
                                Data tidak ditemukan
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Alamat Email <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email aktif Anda" class="{{ $errors->has('email') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" class="{{ $errors->has('password') ? 'invalid-input' : '' }}" />
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span style="color: #dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password Anda" />
                    </div>
                </div>

                <button type="submit" class="btn-login" id="submitBtn">
                    <i class="fas fa-user-plus"></i> Registrasi Akun
                </button>
            </form>

            <div class="signup-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        @endif
    </div>

    <!-- Script Interaktif Custom Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('customSelect');
            if (!container) return;

            const trigger = container.querySelector('.custom-select-trigger');
            const selectedText = document.getElementById('selectedText');
            const hiddenInput = document.getElementById('peserta_id');
            const searchInput = document.getElementById('searchInput');
            const optionsList = document.getElementById('optionsList');
            const optionItems = optionsList.querySelectorAll('.option-item');
            const noResults = document.getElementById('noResults');

            // Toggle Dropdown
            function toggleDropdown(e) {
                if (e) e.stopPropagation();
                const isOpen = container.classList.contains('open');
                if (isOpen) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            }

            function openDropdown() {
                container.classList.add('open');
                searchInput.value = '';
                filterOptions('');
                setTimeout(() => searchInput.focus(), 50);
            }

            function closeDropdown() {
                container.classList.remove('open');
            }

            trigger.addEventListener('click', toggleDropdown);

            // Close on click outside
            document.addEventListener('click', function (e) {
                if (!container.contains(e.target)) {
                    closeDropdown();
                }
            });

            // Filter Options
            function filterOptions(query) {
                const q = query.toLowerCase().trim();
                let hasVisible = false;

                optionItems.forEach(item => {
                    const searchData = item.getAttribute('data-search') || '';
                    if (searchData.includes(q)) {
                        item.style.display = 'flex';
                        hasVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                noResults.style.display = hasVisible ? 'none' : 'block';
            }

            searchInput.addEventListener('input', function () {
                filterOptions(this.value);
            });

            // Select Option
            function selectOption(item) {
                const id = item.getAttribute('data-id');
                const name = item.getAttribute('data-name');
                const nisn = item.getAttribute('data-nisn');
                const instansi = item.getAttribute('data-instansi');

                hiddenInput.value = id;
                selectedText.innerHTML = `<strong>${name}</strong> <span style="font-size:0.8rem; color:#64748b;">[${nisn}] - ${instansi}</span>`;
                selectedText.classList.remove('placeholder');

                optionItems.forEach(el => el.classList.remove('selected'));
                item.classList.add('selected');

                container.classList.remove('invalid');
                closeDropdown();
            }

            optionItems.forEach(item => {
                item.addEventListener('click', function () {
                    selectOption(this);
                });
            });

            // Handle Old Input value if validation failed
            const oldId = hiddenInput.value;
            if (oldId) {
                const preselectedItem = optionsList.querySelector(`.option-item[data-id="${oldId}"]`);
                if (preselectedItem) {
                    selectOption(preselectedItem);
                }
            }

            // Client-side validation check on submit
            const form = document.getElementById('registerForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    if (!hiddenInput.value) {
                        e.preventDefault();
                        container.classList.add('invalid');
                        openDropdown();
                    }
                });
            }
        });
    </script>
</body>

</html>
