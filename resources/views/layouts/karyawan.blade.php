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
    {{-- SIDEBAR                                                  --}}
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

            <a href="{{ route('karyawan.dashboard') }}"
               id="nav-dashboard"
               class="o-nav__item {{ request()->routeIs('karyawan.dashboard') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/iconhome.svg') }}"
                     alt="" class="o-nav__icon-img">
                <span>Dashboard</span>
            </a>

            <a href="{{ route('karyawan.kesehatan.index') }}"
               id="nav-kesehatan"
               class="o-nav__item {{ request()->routeIs('karyawan.kesehatan.*') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/iconsapikecil.svg') }}"
                     alt="" class="o-nav__icon-img">
                <span>Data Sapi</span>
            </a>

            <a href="{{ route('karyawan.produksi.index') }}"
               id="nav-produksi"
               class="o-nav__item {{ request()->routeIs('karyawan.produksi.*') ? 'o-nav__item--active' : '' }}">
                <img src="{{ asset('images/icons/iconbotolsusukecil.svg') }}"
                     alt="" class="o-nav__icon-img">
                <span>Produksi Susu</span>
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

        {{-- Topbar --}}
        <header class="o-topbar">
            <div class="o-topbar__left" style="display: flex; align-items: flex-start; gap: 16px;">
                <button class="o-topbar__hamburger" id="sidebarToggle" aria-label="Toggle sidebar" style="display: flex; align-items: center; justify-content: center; background: none; border: none; padding: 0; cursor: pointer; margin-top: 2px;">
                    <img src="{{ asset('images/icons/iconhamburger.svg') }}" alt="Menu" style="width: 24px; height: 24px;">
                </button>
                <div class="o-topbar__page" style="display: flex; flex-direction: column; align-items: flex-start; gap: 4px; font-size: inherit; font-weight: inherit; color: inherit;">
                    <span style="font-size: 20px; font-weight: 800; color: #124827; font-family: 'Manrope', sans-serif; line-height: 1.2;">
                        @yield('page-title', 'Dashboard')
                    </span>
                    @if (trim($__env->yieldContent('page-subtitle')))
                        <span style="font-size: 13px; font-weight: 700; color: #4B5563; font-family: 'Manrope', sans-serif; line-height: 1.2;">
                            @yield('page-subtitle')
                        </span>
                    @endif
                </div>
            </div>
            <div class="o-topbar__right" style="display: flex; align-items: center;">
                @hasSection('topbar-right')
                    @yield('topbar-right')
                @else
                    <div class="o-user" style="display: flex; align-items: center; gap: 10px; font-family: 'Manrope', sans-serif;">
                        <div class="o-user__avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #124827; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #FFFFFF; font-weight: 800; font-size: 16px;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-start; justify-content: center;">
                            <span style="font-size: 15px; font-weight: 800; color: #000000; line-height: 1.2; margin: 0;">{{ auth()->user()->name ?? 'Karyawan' }}</span>
                            <span style="font-size: 13px; font-weight: 500; color: #7F7F7F; line-height: 1.2; margin: 2px 0 0 0;">Karyawan</span>
                        </div>
                    </div>
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
