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
                        Jangan khawatir! Silakan hubungi admin peternakan untuk mereset atau mengganti password akun Anda.
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

                    <header class="login-card__header" style="margin-bottom: 24px;">
                        <h2 class="login-card__title">Lupa Password</h2>
                        <p class="login-card__subtitle">Hubungi Admin Peternakan</p>
                    </header>

                    <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
                        <a href="https://wa.me/{{ config('contact.whatsapp.number') }}?text={{ urlencode(config('contact.whatsapp.text_admin')) }}" target="_blank" class="contact-link contact-link--wa" style="text-decoration: none;">
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

                        <a href="mailto:{{ config('contact.email') }}?subject=Bantuan%20Akun%20Parman%20Farm" class="contact-link contact-link--email" style="text-decoration: none;">
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

                    <div class="login-footer">
                        <a href="{{ route('login') }}" class="contact-admin">
                            Kembali ke Halaman Login
                        </a>
                    </div>

                </section>

            </aside>

        </div>

    </main>

</body>

</html>
