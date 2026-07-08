<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password | Parman Farm</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <main class="login-page">

        {{-- Background --}}
        <div
            class="login-background"
            style="background-image: url('{{ asset('images/backgrounds/Bglogin.jpg') }}');"></div>

        {{-- Overlay --}}
        <div class="login-overlay"></div>

        {{-- Container --}}
        <div class="login-container">

            {{-- ============================================= --}}
            {{-- LEFT SIDE — HERO                              --}}
            {{-- ============================================= --}}
            <section class="login-hero">

                {{-- Brand --}}
                <header class="hero-brand">
                    <img
                        src="{{ asset('images/logo/logologin.png') }}"
                        alt="Logo Peternakan Pak Suparman"
                        class="hero-brand__logo">
                    <div class="hero-brand__content">
                        <h1 class="hero-brand__title">Peternakan Pak Suparman</h1>
                        <p class="hero-brand__subtitle">Sapi Perah Berkualitas</p>
                    </div>
                </header>

                {{-- Tagline --}}
                <section class="hero-content">
                    <h2 class="hero-content__title">
                        Atur Ulang<br>Password
                    </h2>
                    <p class="hero-content__description">
                        Silakan buat password baru Anda di samping untuk memulihkan akses penuh ke akun Anda.
                    </p>
                </section>

                {{-- Feature List --}}
                <section class="hero-features">

                    {{-- Aman --}}
                    <article class="feature-item">
                        <div class="feature-item__icon">
                            <img
                                src="{{ asset('images/icons/icontamengcentangtengah.svg') }}"
                                alt="Aman">
                        </div>
                        <div class="feature-item__content">
                            <h3 class="feature-item__title">Aman</h3>
                            <p class="feature-item__description">Data Peternakan Anda terlindungi dengan baik</p>
                        </div>
                    </article>

                    {{-- Terstruktur --}}
                    <article class="feature-item">
                        <div class="feature-item__icon">
                            <img
                                src="{{ asset('images/icons/iconbranch.svg') }}"
                                alt="Terstruktur">
                        </div>
                        <div class="feature-item__content">
                            <h3 class="feature-item__title">Terstruktur</h3>
                            <p class="feature-item__description">Kelola data dengan lebih mudah</p>
                        </div>
                    </article>

                </section>

            </section>

            {{-- ============================================= --}}
            {{-- RIGHT SIDE — RESET PASSWORD FORM              --}}
            {{-- ============================================= --}}
            <aside class="login-panel">

                <section class="login-card">

                    <header class="login-card__header">
                        <h2 class="login-card__title">Password Baru</h2>
                        <p class="login-card__subtitle">Masukkan password baru untuk akun Anda</p>
                    </header>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="login-alert login-alert--danger">
                            <ul style="margin:0; padding:0; list-style:none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}" class="login-form">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        {{-- Email Address --}}
                        <div class="form-group">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $request->email) }}"
                                placeholder="Masukkan Email Anda"
                                class="form-input"
                                required
                                autofocus
                                autocomplete="username">
                        </div>

                        {{-- Password --}}
                        <div class="form-group" style="margin-top: 16px;">
                            <label for="password" class="form-label">Password Baru</label>
                            <div class="password-group">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Masukkan Password Baru"
                                    class="form-input"
                                    required
                                    autocomplete="new-password">
                                <button type="button" id="togglePassword" class="password-toggle" aria-label="Tampilkan password">
                                    <svg id="eyeOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg id="eyeClosed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group" style="margin-top: 16px;">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <div class="password-group">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    placeholder="Ulangi Password Baru"
                                    class="form-input"
                                    required
                                    autocomplete="new-password">
                                <button type="button" id="toggleConfirmPassword" class="password-toggle" aria-label="Tampilkan password">
                                    <svg id="eyeOpenConfirm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg id="eyeClosedConfirm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="login-button" style="margin-top: 10px;">
                            Reset Password
                        </button>

                    </form>

                </section>

            </aside>

        </div>

    </main>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput  = document.getElementById('password');
        const eyeOpen        = document.getElementById('eyeOpen');
        const eyeClosed      = document.getElementById('eyeClosed');

        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                eyeOpen.style.display   = isHidden ? 'none'  : 'block';
                eyeClosed.style.display = isHidden ? 'block' : 'none';
                this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            });
        }

        // Toggle confirm password visibility
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput  = document.getElementById('password_confirmation');
        const eyeOpenConfirm        = document.getElementById('eyeOpenConfirm');
        const eyeClosedConfirm      = document.getElementById('eyeClosedConfirm');

        if (toggleConfirmPassword) {
            toggleConfirmPassword.addEventListener('click', function () {
                const isHidden = confirmPasswordInput.type === 'password';
                confirmPasswordInput.type = isHidden ? 'text' : 'password';
                eyeOpenConfirm.style.display   = isHidden ? 'none'  : 'block';
                eyeClosedConfirm.style.display = isHidden ? 'block' : 'none';
                this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            });
        }
    </script>

</body>

</html>
