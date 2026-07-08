<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Parman Farm</title>
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
                        Selamat Datang<br>Kembali!
                    </h2>
                    <p class="hero-content__description">
                        Silahkan masuk untuk melanjutkan pengelolaan peternakan Anda.
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

                    {{-- Transparan --}}
                    <article class="feature-item">
                        <div class="feature-item__icon">
                            <img
                                src="{{ asset('images/icons/iconkacamata.svg') }}"
                                alt="Transparan">
                        </div>
                        <div class="feature-item__content">
                            <h3 class="feature-item__title">Transparan</h3>
                            <p class="feature-item__description">Informasi akurat dan dapat dipercaya</p>
                        </div>
                    </article>

                </section>

            </section>

            {{-- ============================================= --}}
            {{-- RIGHT SIDE — LOGIN FORM                       --}}
            {{-- ============================================= --}}
            <aside class="login-panel">

                <section class="login-card">

                    <header class="login-card__header">
                        <h2 class="login-card__title">Login</h2>
                        <p class="login-card__subtitle">Masuk untuk mengakses dashboard</p>
                    </header>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="login-alert login-alert--success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="login-alert login-alert--danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        {{-- Username / Email --}}
                        <div class="form-group">
                            <label for="email" class="form-label">Username</label>
                            <input
                                id="email"
                                name="email"
                                type="text"
                                value="{{ old('email') }}"
                                autocomplete="username"
                                placeholder="Masukkan Username"
                                class="form-input"
                                required
                                autofocus>
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-group">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    placeholder="Masukkan Password"
                                    class="form-input"
                                    required>
                                {{-- Toggle password visibility --}}
                                <button type="button" id="togglePassword" class="password-toggle" aria-label="Tampilkan password">
                                    {{-- Eye icon (password hidden) --}}
                                    <svg id="eyeOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    {{-- Eye-off icon (password visible) --}}
                                    <svg id="eyeClosed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="login-options">
                            <label class="remember-me">
                                <input type="checkbox" name="remember">
                                <span>Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-password">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button type="submit" id="loginButton" class="login-button">
                            Login
                        </button>

                        {{-- Footer --}}
                        <div class="login-footer">
                            <span>Belum punya akun? </span>
                            <a href="#" class="contact-admin">Kontak Admin</a>
                        </div>

                    </form>

                </section>

            </aside>

        </div>

    </main>

    {{-- Contact Admin Modal --}}
    <div id="contactAdminModal" class="login-modal" style="display: none;">
        <div class="login-modal__overlay" onclick="closeContactModal()"></div>
        <div class="login-modal__card">
            {{-- Close button --}}
            <button class="login-modal__close-btn" onclick="closeContactModal()" aria-label="Tutup modal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="18" height="18">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>

            {{-- Decorative Icon --}}
            <div class="login-modal__icon-decor">
                <svg viewBox="0 0 24 24" fill="none" stroke="#124827" stroke-width="2.5" width="28" height="28">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>

            <header class="login-modal__header">
                <h3>Hubungi Admin Peternakan</h3>
                <p>Silakan hubungi kontak di bawah ini untuk pendaftaran akun baru atau bantuan pemulihan akses.</p>
            </header>

            <div class="login-modal__body">
                <a href="https://wa.me/{{ config('contact.whatsapp.number') }}?text={{ urlencode(config('contact.whatsapp.text_admin')) }}" target="_blank" class="contact-link contact-link--wa">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="22" height="22">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                    <div class="contact-link__text">
                        <span class="contact-link__title">WhatsApp Admin</span>
                        <span class="contact-link__val">{{ config('contact.whatsapp.display') }}</span>
                    </div>
                    <svg class="contact-link__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>

                <a href="mailto:{{ config('contact.email') }}?subject=Bantuan%20Akun%20Parman%20Farm" class="contact-link contact-link--email">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <div class="contact-link__text">
                        <span class="contact-link__title">Email Resmi</span>
                        <span class="contact-link__val">{{ config('contact.email') }}</span>
                    </div>
                    <svg class="contact-link__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
            </div>

            <footer class="login-modal__footer">
                <button type="button" class="login-modal__btn-primary" onclick="closeContactModal()">Kembali</button>
            </footer>
        </div>
    </div>

    <script>
        // Contact Admin Modal Logic
        const contactLink = document.querySelector('.contact-admin');
        const modal = document.getElementById('contactAdminModal');

        if (contactLink && modal) {
            contactLink.addEventListener('click', function (e) {
                e.preventDefault();
                modal.style.display = 'flex';
            });
        }

        function closeContactModal() {
            const modal = document.getElementById('contactAdminModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
    </script>

</body>
</html>
