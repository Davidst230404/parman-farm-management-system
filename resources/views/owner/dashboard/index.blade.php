@extends('layouts.owner')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-right')
<div class="o-user" style="display: flex; align-items: center; gap: 10px; font-family: 'Manrope', sans-serif;">
    <div class="o-user__avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #124827; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #FFFFFF; font-weight: 800; font-size: 16px;">
        {{ strtoupper(substr(auth()->user()->name ?? 'O', 0, 1)) }}
    </div>
    <div style="display: flex; flex-direction: column; align-items: flex-start; justify-content: center;">
        <span class="o-user__name" style="font-size: 15px; font-weight: 800; color: #000000; line-height: 1.2; margin: 0;">{{ auth()->user()->name ?? 'Owner' }}</span>
        <span class="o-user__role" style="font-size: 13px; font-weight: 500; color: #7F7F7F; line-height: 1.2; margin: 2px 0 0 0;">Pemilik</span>
    </div>
</div>
@endsection

@section('content')

{{-- ============================================================ --}}
{{-- WELCOME                                                      --}}
{{-- ============================================================ --}}
{{-- WELCOME --}}
@include('owner.components.page-header', [
    'title' => 'Selamat datang, ' . (auth()->user()->name ?? 'Owner') . '!',
    'subtitle' => 'Berikut ringkasan aktivitas peternakan hari ini.',
    'actions' => '
        <div class="dash-welcome__date" style="position: relative; cursor: pointer;">
            ' . $today->locale('id')->isoFormat('D MMMM YYYY') . '
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
            <input type="date" value="' . $today->format('Y-m-d') . '" onchange="window.location.href=\'' . route('owner.dashboard') . '?date=\' + this.value" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; border: none; padding: 0; margin: 0; pointer-events: auto;">
        </div>
    '
])

{{-- STAT CARDS --}}
<div class="dash-stats">

    @include('owner.components.stat-card', [
        'theme' => 'dark',
        'icon' => 'resources/images/icons/iconsapihijaucarddashboard.svg',
        'value' => $totalSapi,
        'label' => 'Total Sapi',
        'sub' => 'Semua Sapi',
        'valueId' => 'stat-total-sapi',
        'subId' => 'stat-total-sapi-sub'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'green',
        'icon' => 'resources/images/icons/tamengplus.svg',
        'value' => $sapiSehat,
        'label' => 'Sapi Sehat',
        'sub' => $persenSehat . ' % dari keseluruhan',
        'valueId' => 'stat-sapi-sehat',
        'subId' => 'stat-sapi-sehat-sub'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'blue',
        'icon' => 'resources/images/icons/iconsusunyasapi.svg',
        'value' => $sudahDiperah,
        'label' => 'Sudah Diperah Hari ini',
        'sub' => $persenDiperah . ' % dari keseluruhan',
        'valueId' => 'stat-sudah-diperah',
        'subId' => 'stat-sudah-diperah-sub'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'purple',
        'icon' => 'resources/images/icons/icondogtag.svg',
        'value' => number_format($terjualHariIniVolume, 0, ',', '.') . '<span class="stat-card__value-unit">L</span>',
        'label' => 'Terjual Hari Ini',
        'sub' => 'Rp ' . number_format($terjualHariIniPendapatan, 0, ',', '.'),
        'valueId' => 'stat-terjual-volume',
        'subId' => 'stat-terjual-pendapatan'
    ])

</div>

{{-- ============================================================ --}}
{{-- MIDDLE ROW : Chart + Aktivitas Terbaru                      --}}
{{-- ============================================================ --}}
<div class="dash-row">

    {{-- Chart --}}
    <div class="dash-chart">
        <div class="dash-card__header">
            <h3 class="dash-card__title">
                Produksi Susu
                <span>(7 Hari Terakhir)</span>
            </h3>
        </div>
        <div class="dash-chart__canvas-wrap">
            <canvas id="produksiChart"></canvas>
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="dash-activity">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Aktivitas Terbaru</h3>
            <a href="{{ route('owner.kesehatan.index') }}" class="dash-card__link">Lihat semua</a>
        </div>
        <div class="activity-list">

            @forelse($latestActivities as $activity)
                <div class="activity-item">
                    <div class="activity-item__dot">
                        <img src="{{ asset('images/icons/iconplus.svg') }}" alt="" style="width:16px; height:16px; filter: brightness(0) invert(1);">
                    </div>
                    <div style="flex:1;">
                        <p class="activity-item__text">{{ $activity->sapi->name }} ({{ $activity->sapi->code }}) — <span class="kd-badge @if($activity->status === 'Normal') kd-badge--success @else kd-badge--warning @endif" style="font-size:10px; padding:2px 8px;">{{ $activity->status }}</span></p>
                        <p class="activity-item__date" style="margin-top:2px;">{{ Str::limit($activity->catatan, 35) }} • {{ $activity->created_at->locale('id')->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p style="font-size:13px;color:#6B7280;text-align:center;padding:32px 0;">Belum ada aktivitas hari ini.</p>
            @endforelse

        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- BOTTOM ROW                                                   --}}
{{-- ============================================================ --}}
<div class="dash-row2">

    {{-- Sapi dengan Produksi Tertinggi — solid circles (Figma) --}}
    <div class="dash-bottom-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Sapi dengan Produksi Tertinggi</h3>
        </div>
        <div class="top-producers-list">
            @forelse($topSapi as $index => $prod)
                <div class="top-producer-item">
                    <div class="top-producer-dot">{{ $index + 1 }}</div>
                    <span class="top-producer-name">{{ $prod->sapi->name }} ({{ $prod->sapi->code }})</span>
                    <span class="top-producer-value">{{ round($prod->total_susu) }} Liter</span>
                </div>
            @empty
                <p style="font-size:13px;color:#6B7280;text-align:center;padding:24px 0;">Belum ada data produksi.</p>
            @endforelse
        </div> 
    </div>

    {{-- Penjualan Bulan Ini --}}
    <div class="dash-bottom-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Penjualan Bulan Ini</h3>
        </div>
        <div class="dash-sales__row">
            <div class="dash-sales__block">
                <div class="dash-sales__big">
                    {{ number_format($currentMonthVol, 0, ',', '.') }} <span class="dash-sales__big-unit">Liter</span>
                </div>
                <p class="dash-sales__sub">Total terjual.</p>
            </div>
            <div class="dash-sales__block">
                <div class="dash-sales__rp">Rp {{ number_format($currentMonthRev, 0, ',', '.') }}</div>
                <p class="dash-sales__sub">Total pendapatan.</p>
            </div>
        </div>
        {{-- Plain text, no badge — Figma exact --}}
        <p class="dash-sales__growth" style="color: @if($salesGrowth > 0) #16A34A @elseif($salesGrowth < 0) #DC2626 @else #6B7280 @endif;">
            @if($salesGrowth > 0)
                ▲ {{ $salesGrowth }}% dari bulan lalu
            @elseif($salesGrowth < 0)
                ▼ {{ abs($salesGrowth) }}% dari bulan lalu
            @else
                — dari bulan lalu
            @endif
        </p>
    </div>

    {{-- Mitra Aktif --}}
    <div class="dash-bottom-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Mitra Aktif</h3>
        </div>
        <div class="mitra-box">
            <div class="mitra-box__logo">
                <img src="{{ asset('images/icons/iconjabattangan.svg') }}"
                     alt="Mitra Logo">
            </div>
            <div>
                <p class="mitra-box__name">{{ $activeMitra && $activeMitra->mitra ? $activeMitra->mitra->nama : 'Greenfields' }}</p>
                <p class="mitra-box__type">Mitra Utama</p>
            </div>
        </div>
        <a href="{{ route('owner.penjualan.index') }}" class="mitra-box__link">
            Lihat detail
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="11" height="11">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('produksiChart');
    if (!ctx || typeof Chart === 'undefined') return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Produksi (Liter)',
                data: {!! json_encode($chartData) !!},
                fill: true,
                backgroundColor: 'rgba(18,72,39,0.10)',
                borderColor: '#124827',
                borderWidth: 2.5,
                pointBackgroundColor: '#124827',
                pointRadius: 3.5,
                pointHoverRadius: 5,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#124827',
                    titleFont: { family: 'Manrope', weight: '700', size: 11 },
                    bodyFont:  { family: 'Manrope', weight: '600', size: 11 },
                    padding: 8,
                    cornerRadius: 7,
                    callbacks: { label: c => ` ${c.parsed.y} Liter` }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Manrope', weight: '600', size: 10 }, color: '#9CA3AF' },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    max: {{ max(100, (max($chartData) ?? 0) + 20) }},
                    grid: { color: '#F3F4F6' },
                    ticks: { font: { family: 'Manrope', weight: '600', size: 10 }, color: '#9CA3AF', stepSize: 20 },
                    border: { display: false }
                }
            }
        }
    });
});
</script>

{{-- ══ LIVE POLLING SCRIPT ══════════════════════════════════════ --}}
<script>
(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeDate = urlParams.get('date') || '{{ $today->format("Y-m-d") }}';
    const apiUrl = '{{ route("owner.api.dashboard") }}';

    /* ── Live badge ───────────────────────────────────────────── */
    const liveBadge = document.createElement('span');
    liveBadge.id    = 'live-badge-dashboard';
    liveBadge.innerHTML = '● Live';
    liveBadge.style.cssText = [
        'display:inline-flex', 'align-items:center', 'gap:4px',
        'font-size:11px', 'font-weight:700', 'color:#10B981',
        'background:#D1FAE5', 'border-radius:20px',
        'padding:3px 10px', 'margin-left:10px',
        'font-family:Manrope,sans-serif',
        'animation:livePulse 2s infinite',
        'vertical-align:middle'
    ].join(';');

    // Inject badge CSS if not exists
    if (!document.getElementById('live-pulse-css')) {
        const style = document.createElement('style');
        style.id = 'live-pulse-css';
        style.textContent = `
            @keyframes livePulse {
                0%,100%{opacity:1} 50%{opacity:.4}
            }
            @keyframes liveFlash {
                0%{background:#D1FAE5} 30%{background:#6EE7B7} 100%{background:#D1FAE5}
            }
            .live-flash { animation: liveFlash 0.6s ease !important; }
        `;
        document.head.appendChild(style);
    }

    // Attach badge next to title
    const titleEl = document.querySelector('.kp-page-header__title, .ps-page-header h2, h2, h1');
    if (titleEl) titleEl.appendChild(liveBadge);

    function flashBadge() {
        liveBadge.classList.remove('live-flash');
        void liveBadge.offsetWidth; // reflow
        liveBadge.classList.add('live-flash');
    }

    /* ── Poll function ────────────────────────────────────────── */
    function pollDashboard() {
        fetch(apiUrl + '?date=' + activeDate)
            .then(r => r.json())
            .then(data => {
                flashBadge();

                /* 1. Update stat cards ────────────────────── */
                const setStat = (id, val) => {
                    const el = document.getElementById(id);
                    if (el) el.innerHTML = val;
                };

                setStat('stat-total-sapi', data.stats.total_sapi);
                setStat('stat-sapi-sehat', data.stats.sapi_sehat);
                setStat('stat-sapi-sehat-sub', data.stats.persen_sehat + ' % dari keseluruhan');

                setStat('stat-sudah-diperah', data.stats.sudah_diperah);
                setStat('stat-sudah-diperah-sub', data.stats.persen_diperah + ' % dari keseluruhan');

                setStat('stat-terjual-volume', data.stats.terjual_volume.toLocaleString('id-ID') + '<span class="stat-card__value-unit">L</span>');
                setStat('stat-terjual-pendapatan', 'Rp ' + data.stats.terjual_pendapatan.toLocaleString('id-ID'));

                /* 2. Update recent activities list ────────── */
                const listEl = document.querySelector('.activity-list');
                if (listEl) {
                    if (data.activities.length === 0) {
                        listEl.innerHTML = '<p style="font-size:13px;color:#6B7280;text-align:center;padding:32px 0;">Belum ada aktivitas hari ini.</p>';
                    } else {
                        let html = '';
                        data.activities.forEach(act => {
                            const badgeClass = act.status === 'Normal' ? 'kd-badge--success' : 'kd-badge--warning';
                            html += `
                                <div class="activity-item">
                                    <div class="activity-item__dot">
                                        <img src="/images/icons/iconplus.svg" alt="" style="width:16px; height:16px; filter: brightness(0) invert(1);">
                                    </div>
                                    <div style="flex:1;">
                                        <p class="activity-item__text">${act.sapi_name} (${act.sapi_code}) — <span class="kd-badge ${badgeClass}" style="font-size:10px; padding:2px 8px;">${act.status}</span></p>
                                        <p class="activity-item__date" style="margin-top:2px;">${act.catatan || ''} • ${act.time}</p>
                                    </div>
                                </div>
                            `;
                        });
                        listEl.innerHTML = html;
                    }
                }
            })
            .catch(() => { /* silent fail */ });
    }

    /* ── Start polling every 30 seconds ──────────────────────── */
    setInterval(pollDashboard, 30000);
})();
</script>
@endpush

