<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Parman Farm</title>

    @vite(['resources/css/app.css', 'resources/css/owner/owner.css', 'resources/js/app.js'])

    {{-- Chart.js CDN (no defer — must be available before page scripts) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @stack('styles')
</head>

<body class="owner-body">
<div class="owner-wrap">

    {{-- ======================================================= --}}
    {{-- SIDEBAR — Figma: 280px, #124827                         --}}
    {{-- ======================================================= --}}
    <aside class="o-sidebar" id="ownerSidebar">

        {{-- Brand --}}
        <div class="o-brand">
            <img
                src="{{ asset('images/logo/logologin.png') }}"
                alt="Logo Parman Farm"
                class="o-brand__logo">
            <div class="o-brand__text">
                <span class="o-brand__name">Peternakan Pak Suparman</span>
                <span class="o-brand__sub">Sapi Perah Berkualitas</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="o-nav">

            <a href="{{ route('owner.dashboard') }}"
               id="nav-dashboard"
               class="o-nav__item {{ request()->routeIs('owner.dashboard') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/iconhome.svg') }}"
                     alt="" class="o-nav__icon-img">
                <span>Dashboard</span>
            </a>

            <div class="o-nav__item-group">
                <a href="{{ route('owner.kesehatan.index') }}"
                   id="nav-kesehatan"
                   class="o-nav__item {{ request()->routeIs('owner.kesehatan.*') ? 'o-nav__item--active' : '' }}">
                    <img src="{{ asset('images/icons/iconsapikecil.svg') }}"
                         alt="" class="o-nav__icon-img">
                    <span>Data Sapi</span>
                </a>
                <div class="o-nav__sub" style="padding-left: 24px; padding-right: 12px; display: flex; flex-direction: column; gap: 4px; margin-top: 6px; margin-bottom: 8px;">
                    <a href="{{ route('owner.kesehatan.index') }}" class="o-nav__sub-item" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #FFFFFF; font-size: 13.5px; font-weight: 700; padding: 6px 12px; border-radius: 8px; transition: background 0.15s, opacity 0.15s; opacity: {{ request()->routeIs('owner.kesehatan.index') ? '1' : '0.65' }}; {{ request()->routeIs('owner.kesehatan.index') ? 'background: #6B9B69;' : '' }}">
                        <img src="{{ asset('images/icons/circleputih.svg') }}" style="width: 6px; height: 6px;" alt="">
                        Data Sapi
                    </a>
                    <a href="{{ route('owner.kesehatan.observasi') }}" class="o-nav__sub-item" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #FFFFFF; font-size: 13.5px; font-weight: 700; padding: 6px 12px; border-radius: 8px; transition: background 0.15s, opacity 0.15s; opacity: {{ request()->routeIs('owner.kesehatan.observasi') ? '1' : '0.65' }}; {{ request()->routeIs('owner.kesehatan.observasi') ? 'background: #6B9B69;' : '' }}">
                        <img src="{{ asset('images/icons/circleputih.svg') }}" style="width: 6px; height: 6px;" alt="">
                        Observasi Kesehatan
                    </a>
                </div>
            </div>

            <a href="{{ route('owner.produksi.index') }}"
               id="nav-produksi"
               class="o-nav__item {{ request()->routeIs('owner.produksi.*') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/iconbotolsusukecil.svg') }}"
                     alt="" class="o-nav__icon-img">
                <span>Produksi Susu</span>
            </a>

            <a href="{{ route('owner.penjualan.index') }}"
               id="nav-penjualan"
               class="o-nav__item {{ request()->routeIs('owner.penjualan.*') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/icontasbelanja.svg') }}"
                     alt="" class="o-nav__icon-img">
                <span>Penjualan Susu</span>
            </a>

            <a href="{{ route('owner.laporan.index') }}"
               id="nav-laporan"
               class="o-nav__item {{ request()->routeIs('owner.laporan.*') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/iconlaporansidebar.svg') }}"
                     alt="" class="o-nav__icon-img">
                <span>Laporan</span>
            </a>

            <a href="{{ route('owner.karyawan.index') }}"
               id="nav-karyawan"
               class="o-nav__item {{ request()->routeIs('owner.karyawan.*') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/iconorang.svg') }}"
                     alt="" class="o-nav__icon-img" style="filter: brightness(0) invert(1);">
                <span>Kelola Karyawan</span>
            </a>

        </nav>

        {{-- Logout --}}
        <div class="o-sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="o-logout" id="btn-logout">
                    <img src="{{ asset('images/icons/iconpintukeluar.svg') }}"
                         alt="" class="o-nav__icon-img">
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- ======================================================= --}}
    {{-- MAIN                                                     --}}
    {{-- ======================================================= --}}
    <div class="o-main">

        {{-- Topbar — Figma: 72px height --}}
        <header class="o-topbar" style="height: auto; min-height: 72px; padding: 16px 32px;">
            <div class="o-topbar__left" style="display: flex; align-items: flex-start; gap: 16px;">
                <button class="o-topbar__hamburger" id="sidebarToggle" aria-label="Toggle sidebar" style="display: flex; align-items: center; justify-content: center; background: none; border: none; padding: 0; cursor: pointer; margin-top: 2px;">
                    <img src="{{ asset('images/icons/iconhamburger.svg') }}" alt="Menu" style="width: 24px; height: 24px;">
                </button>
                <div class="o-topbar__page" style="display: flex; flex-direction: column; align-items: flex-start; gap: 2px;">
                    <span style="font-size: 20px; font-weight: 800; color: #124827; font-family: 'Manrope', sans-serif; line-height: 1.2;">
                        @yield('page-title', 'Dashboard')
                    </span>
                    @if (trim($__env->yieldContent('page-subtitle')))
                        <span style="font-size: 14.5px; font-weight: 700; color: #4B5563; font-family: 'Manrope', sans-serif; line-height: 1.2;">
                            @yield('page-subtitle')
                        </span>
                    @endif
                </div>
            </div>
            <div class="o-topbar__right" style="display: flex; align-items: center;">
                @hasSection('topbar-right')
                    @yield('topbar-right')
                @else
                    <span style="font-size: 18px; font-weight: 800; color: #000000; font-family: 'Manrope', sans-serif; cursor: pointer; user-select: none; display: flex; align-items: center; gap: 8px;">
                        {{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM YYYY') }}
                        <span style="font-weight: 900; font-size: 20px; line-height: 1;">&rsaquo;</span>
                    </span>
                @endif
            </div>
        </header>

        {{-- Content --}}
        <main class="o-content" id="ownerContent">
            @yield('content')
        </main>

    </div>

</div>

{{-- Mobile overlay --}}
<div id="sidebarOverlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:100;"
     onclick="closeSidebar()">
</div>

<script>
    const sidebar = document.getElementById('ownerSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    function closeSidebar() {
        sidebar.classList.remove('o-sidebar--open');
        overlay.style.display = 'none';
    }
    const toggle = document.getElementById('sidebarToggle');
    if (toggle) {
        toggle.addEventListener('click', function () {
            const isOpen = sidebar.classList.toggle('o-sidebar--open');
            overlay.style.display = isOpen ? 'block' : 'none';
        });
    }
</script>

@stack('scripts')
</body>
</html>
