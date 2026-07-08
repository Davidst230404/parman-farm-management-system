@extends('layouts.owner')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-right')
<div class="o-user" style="display: flex; align-items: center; gap: 10px; font-family: 'Manrope', sans-serif;">
    <div class="o-user__avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #000000; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #FFFFFF; font-weight: 800; font-size: 16px;">
        O
    </div>
    <div style="display: flex; flex-direction: column; align-items: flex-start; justify-content: center;">
        <span class="o-user__name" style="font-size: 15px; font-weight: 800; color: #000000; line-height: 1.2; margin: 0;">Owner</span>
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
        'sub' => 'Semua Sapi'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'green',
        'icon' => 'resources/images/icons/tamengplus.svg',
        'value' => $sapiSehat,
        'label' => 'Sapi Sehat',
        'sub' => $persenSehat . ' % dari keseluruhan'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'blue',
        'icon' => 'resources/images/icons/iconsusunyasapi.svg',
        'value' => $sudahDiperah,
        'label' => 'Sudah Diperah Hari ini',
        'sub' => $persenDiperah . ' % dari keseluruhan'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'purple',
        'icon' => 'resources/images/icons/icondogtag.svg',
        'value' => number_format($terjualHariIniVolume, 0, ',', '.') . '<span class="stat-card__value-unit">L</span>',
        'label' => 'Terjual Hari Ini',
        'sub' => 'Rp ' . number_format($terjualHariIniPendapatan, 0, ',', '.')
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
@endpush
