<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMAG-DISDIKPROV SUMSEL · Login</title>
    <!-- Preload DNS & Assets untuk mempercepat load -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    <!-- Preload Font Awesome & Inter Font -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style">
    <link rel="preload" href="{{ asset('css/login.css') }}" as="style">
    
    <!-- Load Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-container">
        <!-- Logo -->
        <div class="logo-area">
            <div class="logo-icon" style="background:transparent; box-shadow:none; padding:0; width:52px; height:52px;">
                <img src="{{ asset('images/logo.jpeg') }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;" alt="Logo">
            </div>
            <div class="logo-text">SIMAG-DISDIKPROV<span>SUMSEL</span></div>
        </div>

        <!-- Title -->
        <div class="login-title">
            <h1>Selamat Datang!</h1>
            <p>Login untuk mengakses sistem manajemen magang</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="error-msg" style="background: #f0fdf4; color: #16a34a;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda" class="{{ $errors->has('email') ? 'invalid-input' : '' }}" />
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="{{ $errors->has('password') ? 'invalid-input' : '' }}" />
                </div>
            </div>

            <div class="form-options" style="display: none;">
                <!-- Remember me and forgot password removed as requested -->
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                <i class="fas fa-arrow-right-to-bracket"></i> Masuk
            </button>
        </form>

        <!-- Social login removed as requested -->

        @if (Route::has('register'))
        <div class="signup-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
        @endif
    </div>

    <script>
        window.hasErrors = {{ $errors->any() ? 'true' : 'false' }};
    </script>
    <script src="{{ asset('js/login.js') }}" defer></script>
</body>

</html>
