<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peternakan Pak Suparman | Sapi Perah Berkualitas</title>
    @vite(['resources/css/landing.css'])
</head>
<body>

    <!-- ==========================================
         NAVBAR
         ========================================== -->
    <nav class="l-navbar">
        <a href="#beranda" class="l-brand">
            <img src="{{ asset('images/landingpage/logolandingpage.svg') }}" alt="Parman Farm Logo" class="l-brand__logo">
            <div>
                <h1 class="l-brand__title">Peternakan Pak Suparman</h1>
                <span class="l-brand__subtitle">Sapi Perah Berkualitas</span>
            </div>
        </a>

        <ul class="l-nav-links" id="navLinks">
            <li><a href="#beranda" onclick="closeMenu()">Beranda</a></li>
            <li><a href="#tentang-kami" onclick="closeMenu()">Tentang Kami</a></li>
            <li><a href="#keunggulan" onclick="closeMenu()">Keunggulan</a></li>
            <li><a href="#produksi" onclick="closeMenu()">Produksi</a></li>
            <li><a href="#kesehatan" onclick="closeMenu()">Kesehatan</a></li>
            <li><a href="#galeri" onclick="closeMenu()">Galeri</a></li>
            <li><a href="#kontak" onclick="closeMenu()">Kontak</a></li>
        </ul>

        <a href="{{ route('login') }}" class="l-btn-login">
            <img src="{{ asset('images/landingpage/iconloginowner.svg') }}" alt="">
            Login Owner
        </a>

        <button class="l-hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

    <!-- ==========================================
         HERO SECTION
         ========================================== -->
    <section class="l-hero" id="beranda">
        <div class="l-hero__content">
            <h2 class="l-hero__title">Berkomitmen pada Kualitas, Transparansi, dan Keberlanjutan Peternakan</h2>
            <p class="l-hero__description">
                Kualitas susu yang baik berasal dari kesehatan ternak yang terjaga, pengelolaan peternakan yang terorganisir, serta proses yang dilakukan secara bertanggung jawab dan transparan.
            </p>
            <div class="l-hero__actions">
                <a href="#tentang-kami" class="l-btn-primary">Tentang Kami</a>
                <a href="#produksi" class="l-btn-secondary">
                    <span class="l-btn-secondary__play"></span>
                    Lihat Peternakan
                </a>
            </div>
        </div>
    </section>

    <!-- ==========================================
         FLOATING STAT CARDS
         ========================================== -->
    <section class="l-hero-cards">
        <div class="l-float-card">
            <img src="{{ asset('images/landingpage/iconleaf.svg') }}" alt="" class="l-float-card__icon">
            <div>
                <h4 class="l-float-card__title">Pakan Berkualitas</h4>
                <p class="l-float-card__text">Pakan terbaik untuk sapi yang sehat</p>
            </div>
        </div>
        <div class="l-float-card">
            <img src="{{ asset('images/landingpage/icontamenghealth.svg') }}" alt="" class="l-float-card__icon">
            <div>
                <h4 class="l-float-card__title">Sapi Sehat</h4>
                <p class="l-float-card__text">Perawatan rutin dan monitoring kesehatan</p>
            </div>
        </div>
        <div class="l-float-card">
            <img src="{{ asset('images/landingpage/icontetesanair.svg') }}" alt="" class="l-float-card__icon">
            <div>
                <h4 class="l-float-card__title">Susu Berkualitas</h4>
                <p class="l-float-card__text">Produksi susu segar setiap hari</p>
            </div>
        </div>
        <div class="l-float-card">
            <img src="{{ asset('images/landingpage/iconjabattangan.svg') }}" alt="" class="l-float-card__icon">
            <div>
                <h4 class="l-float-card__title">Terpercaya</h4>
                <p class="l-float-card__text">Membangun kepercayaan bersama mitra</p>
            </div>
        </div>
    </section>

    <!-- ==========================================
         TENTANG KAMI
         ========================================== -->
    <section class="l-section" id="tentang-kami">
        <div class="l-about-grid">
            <div class="l-about__image-container">
                <img src="{{ asset('images/gallery/fototentangkami.png') }}" alt="Tentang Kami" class="l-about__image">
            </div>
            <div class="l-about__text-content">
                <span class="l-tag">Tentang Kami</span>
                <h3 class="l-about__title">Peternakan Sapi Perah<br>Pak Suparman</h3>
                <p class="l-about__description">
                    Kualitas Peternakan Pak Suparman adalah peternakana sapi perah yang berlokasi di Desa Segelan, Wonosari, Malang. Kami fokus pada pengelolaan peternakan yang baik, perawatan sapi yang optimal, serta produksi susu berkualitas tinggi. Dengan pengalaman dan dedikasi, kami terus berupaya memberikan yang terbaik untuk mitra dan konsumen.
                </p>
            </div>
        </div>
    </section>

    <!-- ==========================================
         KEUNGGULAN KAMI
         ========================================== -->
    <section class="l-section" id="keunggulan">
        <span class="l-tag l-tag--center">Keunggulan Kami</span>
        <h3 class="l-section-title l-section-title--center">Mengapa Memilih Peternakan Kami?</h3>
        
        <div class="l-advantages-grid">
            <div class="l-advantage-card">
                <img src="{{ asset('images/landingpage/sapilanding.svg') }}" alt="" class="l-advantage-card__icon">
                <h4 class="l-advantage-card__title">Perawatan Optimal</h4>
                <p class="l-advantage-card__text">Sapi dirawat dengan baik dan diperiksa secara rutin oleh tenaga berpengalaman.</p>
            </div>
            <div class="l-advantage-card">
                <img src="{{ asset('images/landingpage/icontask.svg') }}" alt="" class="l-advantage-card__icon">
                <h4 class="l-advantage-card__title">Pengelolaan Terstruktur</h4>
                <p class="l-advantage-card__text">Pencatatan dan pengelolaan data peternakan dilakukan secara terorganisir.</p>
            </div>
            <div class="l-advantage-card">
                <img src="{{ asset('images/landingpage/icondaun.svg') }}" alt="" class="l-advantage-card__icon">
                <h4 class="l-advantage-card__title">Berkelanjutan</h4>
                <p class="l-advantage-card__text">Kami menerapkan praktik peternakan yang ramah lingkungan dan berkelanjutan.</p>
            </div>
            <div class="l-advantage-card">
                <img src="{{ asset('images/landingpage/iconbotolsusu.svg') }}" alt="" class="l-advantage-card__icon">
                <h4 class="l-advantage-card__title">Susu Segar Berkualitas</h4>
                <p class="l-advantage-card__text">Diproduksi setiap hari dengan standar kebersihan dan kualitas yang terjaga.</p>
            </div>
        </div>
    </section>

    <!-- ==========================================
         PRODUKSI & TRANSPARANSI
         ========================================== -->
    <section class="l-section" id="produksi">
        <div class="l-production-header">
            <span class="l-tag">Produksi & Transparansi</span>
            <h3 class="l-section-title l-production-title">Data Produksi Kami</h3>
        </div>
        <div class="l-production-cards">
            <div class="l-stat-card">
                <img src="{{ asset('images/landingpage/iconkepalasapi.svg') }}" alt="" class="l-stat-card__icon">
                <div class="l-stat-card__value" id="stat-total-sapi">{{ $totalSapi }}+</div>
                <div class="l-stat-card__label">Total Sapi Perah</div>
                <div class="l-stat-card__desc">Sapi sehat dan produktif</div>
            </div>
            
            <div class="l-stat-card">
                <img src="{{ asset('images/landingpage/iconkumpulanbotol.svg') }}" alt="" class="l-stat-card__icon">
                <div class="l-stat-card__value" id="stat-avg-daily">{{ round($avgDaily) }}+</div>
                <div class="l-stat-card__label">Liter / Hari</div>
                <div class="l-stat-card__desc">Rata - rata produksi susu</div>
            </div>
            
            <div class="l-stat-card">
                <img src="{{ asset('images/landingpage/icongrafik.svg') }}" alt="" class="l-stat-card__icon">
                <div class="l-stat-card__value" id="stat-monthly">{{ number_format($monthlyProduction, 0, ',', '.') }}+</div>
                <div class="l-stat-card__label">Liter / Bulan</div>
                <div class="l-stat-card__desc">Total produksi bulan ini</div>
            </div>

            <div class="l-stat-card l-stat-card--image">
                <img src="{{ asset('images/gallery/fotogallery4.png') }}" alt="Production cows" class="l-stat-card__bg-image">
            </div>
        </div>
    </section>

    <!-- ==========================================
         KESEHATAN TERNAK
         ========================================== -->
    <section class="l-section" id="kesehatan">
        <div class="l-health-grid">
            <div class="l-health__text-content">
                <span class="l-tag">Kesehatan Ternak</span>
                <h3 class="l-section-title l-health__title">Kesehatan Sapi adalah Prioritas Kami</h3>
                <p class="l-health__description">
                    Kami melakukan pemeriksaan kesehatan rutin, vaksinasi, dan pemberian vitamin untuk memastikan sapi selalu dalam kondisi sehat dan nyaman.
                </p>
            </div>
            <div class="l-health-images">
                <div class="l-health-image-container">
                    <img src="{{ asset('images/gallery/fotogallery3.png') }}" alt="Vet checking cow" class="l-health-image">
                </div>
                <div class="l-health-image-container">
                    <img src="{{ asset('images/gallery/fotogallery5.png') }}" alt="Cow eating grass" class="l-health-image">
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         GALERI PETERNAKAN
         ========================================== -->
    <section class="l-section" id="galeri">
        <span class="l-tag l-tag--center">Galeri Peternakan</span>
        <h3 class="l-section-title l-section-title--center">Dokumentasi Peternakan</h3>
        
        <div class="l-gallery-grid">
            <div class="l-gallery-item">
                <img src="{{ asset('images/gallery/fotogallery6.png') }}" alt="Gallery cow herd" class="l-gallery-img">
            </div>
            <div class="l-gallery-item">
                <img src="{{ asset('images/gallery/fotogallery2.png') }}" alt="Gallery pasture" class="l-gallery-img">
            </div>
            <div class="l-gallery-item">
                <img src="{{ asset('images/gallery/fotogallery1.png') }}" alt="Gallery milking" class="l-gallery-img">
            </div>
            <div class="l-gallery-item">
                <img src="{{ asset('images/gallery/fotogallery5.png') }}" alt="Gallery fresh milk" class="l-gallery-img">
            </div>
        </div>
    </section>

    <!-- ==========================================
         CTA BANNER & PARTNERSHIP
         ========================================== -->
    <section class="l-cta-banner" id="kontak">
        <div class="l-cta-left">
            <div class="l-cta-logo-wrap">
                <img src="{{ asset('images/gallery/fotohasilproduksi.png') }}" alt="Milk Pitcher" class="l-cta-logo">
            </div>
            <div class="l-cta-info">
                <h3 class="l-cta-title">Tertarik Bekerja Sama?</h3>
                <p class="l-cta-subtitle">Kami Terbuka untuk kemitraan dan kerja sama yang saling menguntungkan. Mari tumbuh bersama.</p>
            </div>
        </div>
        <a href="https://wa.me/6281234567890" target="_blank" class="l-btn-cta">
            Hubungi Kami
            <svg class="l-btn-cta__arrow" viewBox="0 0 48 24" fill="none" stroke="currentColor" stroke-width="2.5" width="36" height="16">
                <line x1="4" y1="12" x2="44" y2="12"/>
                <polyline points="36 6 44 12 36 18"/>
            </svg>
        </a>
    </section>

    <!-- ==========================================
         FOOTER
         ========================================== -->
    <footer class="l-footer">
        <p class="l-footer__copy">2026 Peternakan Pak Suparman. All rights reserved</p>
        <a href="#beranda" class="l-btn-top" aria-label="Back to top">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" width="16" height="16">
                <polyline points="18 15 12 9 6 15"/>
            </svg>
        </a>
    </footer>

    <!-- ==========================================
         MOBILE DRAWER CONTROLLER
         ========================================== -->
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const navLinks = document.getElementById('navLinks');

        if (hamburgerBtn && navLinks) {
            hamburgerBtn.addEventListener('click', () => {
                navLinks.classList.toggle('nav-active');
                hamburgerBtn.classList.toggle('toggle');
                
                // Minimal styling toggle via JS for simplicity and clean layout
                if (navLinks.classList.contains('nav-active')) {
                    navLinks.style.display = 'flex';
                    navLinks.style.flexDirection = 'column';
                    navLinks.style.position = 'absolute';
                    navLinks.style.top = '100%';
                    navLinks.style.left = '0';
                    navLinks.style.width = '100%';
                    navLinks.style.backgroundColor = '#FFFFFF';
                    navLinks.style.padding = '20px 8%';
                    navLinks.style.boxShadow = '0 10px 15px rgba(0,0,0,0.05)';
                    navLinks.style.gap = '20px';
                } else {
                    navLinks.style.display = '';
                }
            });
        }

        function closeMenu() {
            if (navLinks.classList.contains('nav-active')) {
                navLinks.classList.remove('nav-active');
                hamburgerBtn.classList.remove('toggle');
                navLinks.style.display = '';
            }
        }
    </script>

    <!-- ==========================================
         REAL-TIME PRODUCTION STATS SYNC
         Polls /api/landing-stats every 5 minutes
         ========================================== -->
    <script>
        /**
         * Format number with thousands separator (e.g. 1500 -> "1.500")
         */
        function formatNumber(num) {
            return num.toLocaleString('id-ID');
        }

        /**
         * Animate a counter from current displayed value to target value.
         */
        function animateCounter(el, targetNum) {
            const currentText = el.textContent.replace(/[^0-9]/g, '');
            const current = parseInt(currentText) || 0;
            if (current === targetNum) return;

            const duration = 800; // ms
            const steps = 20;
            const step = (targetNum - current) / steps;
            let count = 0;
            const isMonthly = el.id === 'stat-monthly';

            const interval = setInterval(() => {
                count++;
                const value = Math.round(current + step * count);
                el.textContent = (isMonthly ? formatNumber(value) : value) + '+';
                if (count >= steps) {
                    el.textContent = (isMonthly ? formatNumber(targetNum) : targetNum) + '+';
                    clearInterval(interval);
                }
            }, duration / steps);
        }

        /**
         * Fetch latest stats from the server and update the DOM.
         */
        function syncStats() {
            fetch('/api/landing-stats')
                .then(res => res.json())
                .then(data => {
                    const elSapi    = document.getElementById('stat-total-sapi');
                    const elAvg     = document.getElementById('stat-avg-daily');
                    const elMonthly = document.getElementById('stat-monthly');

                    if (elSapi)    animateCounter(elSapi,    data.totalSapi);
                    if (elAvg)     animateCounter(elAvg,     data.avgDaily);
                    if (elMonthly) animateCounter(elMonthly, data.monthlyProduction);
                })
                .catch(() => {
                    // Silently fail — keep showing the server-rendered values
                });
        }

        // Auto-refresh every 5 minutes (300,000ms)
        const REFRESH_INTERVAL_MS = 5 * 60 * 1000;
        setInterval(syncStats, REFRESH_INTERVAL_MS);
    </script>
</body>
</html>
