@extends('layouts.karyawan')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-right')
<div class="o-user" style="display: flex; align-items: center; gap: 10px; font-family: 'Manrope', sans-serif;">
    <div class="o-user__avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #124827; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #FFFFFF; font-weight: 800; font-size: 16px;">
        {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
    </div>
    <div style="display: flex; flex-direction: column; align-items: flex-start; justify-content: center;">
        <span class="o-user__name" style="font-size: 15px; font-weight: 800; color: #000000; line-height: 1.2; margin: 0;">{{ auth()->user()->name ?? 'Karyawan' }}</span>
        <span class="o-user__role" style="font-size: 13px; font-weight: 500; color: #7F7F7F; line-height: 1.2; margin: 2px 0 0 0;">Karyawan</span>
    </div>
</div>
@endsection

@section('content')

{{-- ============================================================ --}}
{{-- WELCOME                                                      --}}
{{-- ============================================================ --}}
@include('owner.components.page-header', [
    'title' => 'Selamat datang, ' . str_replace(' (Karyawan)', '', auth()->user()->name ?? 'Karyawan') . '!',
    'subtitle' => 'Catat produksi susu dan kondisi kesehatan sapi dengan tepat.',
    'actions' => '
        <div class="dash-welcome__date">
            ' . \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') . '
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
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
        'sub' => $persenSehat . ' %'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'blue',
        'icon' => 'resources/images/icons/iconsusunyasapi.svg',
        'value' => $sudahDiperah,
        'label' => 'Sudah Diperah Hari ini',
        'sub' => $persenDiperah . ' %'
    ])

    @include('owner.components.stat-card', [
        'theme' => 'purple',
        'icon' => 'resources/images/icons/botolungu.svg',
        'value' => number_format($produksiSusuHariIni, 0, ',', '.') . '<span class="stat-card__value-unit">L</span>',
        'label' => 'Produksi Susu Hari Ini',
        'sub' => ''
    ])

</div>

{{-- ============================================================ --}}
{{-- MIDDLE ROW : Produksi Susu Hari Ini + Catatan Kesehatan      --}}
{{-- ============================================================ --}}
<div class="dash-row">

    {{-- Produksi Susu Hari Ini --}}
    <div class="dash-chart" style="flex:1.2;">
        <div class="dash-card__header">
            <h3 class="dash-card__title">
                Produksi Susu Hari Ini
                <span>({{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }})</span>
            </h3>
        </div>
        <div style="padding: 0 24px 24px;">
            <table class="kd-table">
                <thead>
                    <tr>
                        <th>Sesi</th>
                        <th>Jumlah Susu</th>
                        <th>Sapi Diperah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight:700;">Pagi</td>
                        <td>{{ $pagiCount > 0 ? number_format($pagiVol, 0, ',', '.') . ' Liter' : '-' }}</td>
                        <td>{{ $pagiCount > 0 ? $pagiCount . ' Ekor' : '-' }}</td>
                        <td>
                            @if($pagiCount > 0)
                                <span class="kd-badge kd-badge--success">Tersimpan</span>
                            @else
                                <span class="kd-badge kd-badge--warning">Belum Input</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:700;">Sore</td>
                        <td>{{ $soreCount > 0 ? number_format($soreVol, 0, ',', '.') . ' Liter' : '-' }}</td>
                        <td>{{ $soreCount > 0 ? $soreCount . ' Ekor' : '-' }}</td>
                        <td>
                            @if($soreCount > 0)
                                <span class="kd-badge kd-badge--success">Tersimpan</span>
                            @else
                                <span class="kd-badge kd-badge--warning">Belum Input</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Catatan Kesehatan Hari Ini --}}
    <div class="dash-activity">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Catatan Kesehatan Hari Ini</h3>
            <a href="{{ route('karyawan.kesehatan.index') }}" class="dash-card__link">Lihat semua</a>
        </div>
        <div class="activity-list">

            @forelse($latestActivities as $activity)
                <div class="activity-item">
                    <div class="kd-avatar"></div>
                    <div style="flex:1;">
                        <p class="activity-item__text">{{ $activity->sapi->name }} ({{ $activity->sapi->code }})</p>
                        <p class="activity-item__date">{{ $activity->catatan }}</p>
                    </div>
                    <div style="text-align:right;">
                        <p class="activity-item__date" style="margin-bottom:4px;">{{ $activity->created_at->format('H:i') }}</p>
                        <span class="kd-badge @if($activity->status === 'Normal') kd-badge--success @else kd-badge--warning @endif" style="font-size:10px;">{{ $activity->status }}</span>
                    </div>
                </div>
            @empty
                <p style="font-size:13px;color:#6B7280;text-align:center;padding:24px 0;">Belum ada pemeriksaan hari ini.</p>
            @endforelse

        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- BOTTOM ROW : Shortcut Cards                                   --}}
{{-- ============================================================ --}}
<div class="kd-shortcuts-combined">

    {{-- Input Produksi Susu --}}
    <a href="{{ route('karyawan.produksi.index') }}" class="kd-shortcut-item" style="text-decoration:none;">
        <div class="kd-shortcut-item__icon-container">
            <img src="{{ asset('images/icons/lingkaranhijau.svg') }}" alt="" class="kd-shortcut-bg">
            <img src="{{ asset('images/icons/botolhijau.svg') }}" alt="" class="kd-shortcut-fg">
        </div>
        <div class="kd-shortcut-item__content">
            <h3 class="kd-shortcut-item__title">Input Produksi Susu (Pemerahan)</h3>
            <p class="kd-shortcut-item__desc">Catat pemerahan sapi pagi atau sore</p>
        </div>
        <div class="kd-shortcut-item__btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="#124827" stroke-width="2.5" width="24" height="24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </div>
    </a>

    <div class="kd-shortcut-divider"></div>

    {{-- Input Kesehatan Sapi --}}
    <a href="{{ route('karyawan.kesehatan.index') }}" class="kd-shortcut-item" style="text-decoration:none;">
        <div class="kd-shortcut-item__icon-container">
            <img src="{{ asset('images/icons/lingkarankunig.svg') }}" alt="" class="kd-shortcut-bg">
            <img src="{{ asset('images/icons/heart kuning.png') }}" alt="" class="kd-shortcut-fg" style="width:32px;height:32px;">
        </div>
        <div class="kd-shortcut-item__content">
            <h3 class="kd-shortcut-item__title">Input Kesehatan Sapi (Observasi)</h3>
            <p class="kd-shortcut-item__desc">Catat kondisi kesehatan sapi</p>
        </div>
        <div class="kd-shortcut-item__btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="#124827" stroke-width="2.5" width="24" height="24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </div>
    </a>

</div>

@endsection

@push('styles')
<style>
/* ============================================================
   Karyawan Dashboard Extra Styles
   ============================================================ */

/* Simple table for produksi susu */
.kd-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

.kd-table th {
    text-align: left;
    font-weight: 700;
    color: #000000;
    padding: 14px 16px;
    background: #D9D9D9;
    border-bottom: none;
    font-size: 13px;
}

.kd-table th:first-child {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.kd-table th:last-child {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.kd-table td {
    padding: 14px 16px;
    color: #374151;
    border-bottom: 1px solid #F3F4F6;
    font-size: 14px;
}

.kd-table tr:last-child td {
    border-bottom: none;
}

/* Badges */
.kd-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.kd-badge--success {
    background: #DEF7EC;
    color: #03543F;
}

.kd-badge--warning {
    background: #FDF6B2;
    color: #8E4B10;
}

.kd-badge--danger {
    background: #FDE8E8;
    color: #9B1C1C;
}

/* Avatar circle for catatan kesehatan */
.kd-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #124827;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Shortcut cards combined layout */
.kd-shortcuts-combined {
    background: #FFFFFF;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #E2E8F0;
    display: flex;
    align-items: center;
    width: 100%;
}

.kd-shortcut-item {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 24px 32px;
    gap: 16px;
    color: inherit;
    cursor: pointer;
    transition: background 0.15s;
    border-radius: 12px;
}

.kd-shortcut-item:hover {
    background: #FAFAFA;
}

.kd-shortcut-item__icon-container {
    position: relative;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.kd-shortcut-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.kd-shortcut-fg {
    position: relative;
    z-index: 1;
    width: 40px;
    height: 40px;
    object-fit: contain;
}

.kd-shortcut-item__content {
    flex: 1;
    min-width: 0;
}

.kd-shortcut-item__title {
    font-size: 15px;
    font-weight: 800;
    color: #000000;
    margin: 0 0 4px;
}

.kd-shortcut-item__desc {
    font-size: 13px;
    color: #6B7280;
    margin: 0;
    font-weight: 500;
}

.kd-shortcut-item__btn {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #DEF7EC;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: transform 0.2s;
}

.kd-shortcut-item:hover .kd-shortcut-item__btn {
    transform: scale(1.05);
}

.kd-shortcut-divider {
    width: 1.5px;
    height: 60px;
    background: #E5E7EB;
    flex-shrink: 0;
    align-self: center;
}

@media (max-width: 768px) {
    .kd-shortcuts-combined {
        flex-direction: column;
    }
    .kd-shortcut-divider {
        width: 100%;
        height: 1.5px;
    }
}

/* Override activity item for karyawan — horizontal layout with badge */
.activity-item {
    display: flex;
    align-items: center;
    gap: 14px;
}
</style>
@endpush
