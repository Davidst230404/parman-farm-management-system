<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | Parman Farm</title>
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
                        Lupa<br>Password?
                    </h2>
                    <p class="hero-content__description">
                        Jangan khawatir! Masukkan alamat email Anda di samping, dan kami akan mengirimkan tautan untuk menyetel ulang password Anda.
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
            {{-- RIGHT SIDE — FORGOT PASSWORD FORM             --}}
            {{-- ============================================= --}}
            <aside class="login-panel">

                <section class="login-card">

                    <header class="login-card__header">
                        <h2 class="login-card__title">Lupa Password</h2>
                        <p class="login-card__subtitle">Kirim tautan reset password ke email Anda</p>
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
                            <ul style="margin:0; padding:0; list-style:none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="login-form">
                        @csrf

                        {{-- Email Address --}}
                        <div class="form-group">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan Email Terdaftar"
                                class="form-input"
                                required
                                autofocus>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="login-button" style="margin-top: 10px;">
                            Kirim Link Reset Password
                        </button>

                        {{-- Footer --}}
                        <div class="login-footer">
                            <a href="{{ route('login') }}" class="contact-admin">
                                Kembali ke Halaman Login
                            </a>
                        </div>

                    </form>

                </section>

            </aside>

        </div>

    </main>

</body>

</html>
