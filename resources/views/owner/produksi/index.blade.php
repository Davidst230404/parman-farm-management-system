@extends('layouts.owner')

@section('title', 'Produksi Susu')
@section('page-title', 'Produksi Susu')

@section('topbar-right')
<div style="position: relative; display: flex; align-items: center;">
    <span id="display-selected-date" style="font-size: 18px; font-weight: 800; color: #000000; font-family: 'Manrope', sans-serif; cursor: pointer; user-select: none; display: flex; align-items: center; gap: 8px;" onclick="try { document.getElementById('topbar-date-picker').showPicker() } catch(e) {}">
        {{ $selectedDate->locale('id')->isoFormat('D MMMM YYYY') }}
        <span style="font-weight: 900; font-size: 20px; line-height: 1; color: #124827;">&rsaquo;</span>
    </span>
    <input type="date" id="topbar-date-picker" value="{{ $selectedDate->format('Y-m-d') }}" style="position: absolute; inset: 0; opacity: 0; pointer-events: auto; cursor: pointer; width: 100%; height: 100%;" onchange="window.location.href = '{{ route('owner.produksi.index') }}?tanggal=' + this.value">
</div>
@endsection

@push('styles')
<style>
/* ============================================================
   Produksi Susu | Owner — compact layout, 100% zoom
   ============================================================ */

/* ── Stat cards — produksi compact version ────────────────── */
.ps-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.ps-stat-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 24px 20px;
    display: grid !important;
    grid-template-areas: 
        "icon value"
        ". label"
        ". sub";
    grid-template-columns: auto 1fr;
    grid-template-rows: auto auto auto;
    align-items: center;
    gap: 4px 16px;
    min-height: 155px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    transition: box-shadow 0.2s, transform 0.15s;
    box-sizing: border-box;
}
.ps-stat-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.09);
    transform: translateY(-2px);
}
.ps-stat-icon-wrap {
    grid-area: icon;
    width: 56px !important;
    height: 56px !important;
    background: transparent !important;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    justify-self: start;
}
.ps-stat-icon-wrap img {
    width: 56px;
    height: 56px;
    object-fit: contain;
}

.ps-stat-content {
    display: contents !important;
}
.ps-stat-value {
    grid-area: value;
    font-size: 38px !important;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -0.5px;
    margin: 0;
    align-self: center;
    justify-self: start;
    text-align: left;
}
.ps-stat-unit {
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0;
}
.ps-stat-card--dark   .ps-stat-value { color: #124827; }
.ps-stat-card--green  .ps-stat-value { color: #124827; }
.ps-stat-card--blue   .ps-stat-value { color: #2563EB; }
.ps-stat-card--purple .ps-stat-value { color: #8027BA; }

.ps-stat-label {
    grid-area: label;
    font-size: 13.5px !important;
    font-weight: 700;
    color: #4B5563;
    margin: 4px 0 0 0 !important;
    line-height: 1.3;
    display: block;
}
.ps-stat-sub {
    grid-area: sub;
    font-size: 13px !important;
    font-weight: 700;
    color: #6B7280;
    margin: 2px 0 0 0 !important;
    line-height: 1.3;
    display: block;
}
.ps-stat-card--green  .ps-stat-sub { color: #124827; font-weight: 700; }
.ps-stat-card--blue   .ps-stat-sub { color: #2563EB; font-weight: 700; }
.ps-stat-card--purple .ps-stat-sub { color: #111827; font-weight: 700; }

/* ── Main card ────────────────────────────────────────────── */
.ps-card {
    background: #FFFFFF;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    border: 1px solid #E2E8F0;
    overflow: hidden;
    margin-bottom: 14px;
}

/* Card header (title + date) */
.ps-card__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px 10px;
    gap: 12px;
}
.ps-card__title {
    font-size: 15px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}
.ps-date-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    background: none;
    border: none;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    padding: 0;
    transition: color 0.15s;
}
.ps-date-btn:hover { color: #124827; }
.ps-date-btn__arrow { color: #124827; font-weight: 900; }

/* Session tabs */
.ps-tabs-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px 10px;
    gap: 12px;
}
.ps-tabs { display: flex; gap: 6px; }

.ps-tab {
    padding: 8px 24px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 800;
    border: none;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: all 0.15s;
}
.ps-tab--active  { background: #124827; color: #FFFFFF; }
.ps-tab--inactive { background: transparent; color: #124827; }
.ps-tab--inactive:hover { opacity: 0.8; }

.ps-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0;
    border: none;
    background: transparent;
    color: #124827;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: opacity 0.15s;
}
.ps-filter-btn:hover { opacity: 0.8; }
.ps-filter-btn img { width: 20px; height: 20px; }

/* Table */
.ps-divider { border: none; border-top: 1px solid #F3F4F6; margin: 0; }
.ps-table-wrap { overflow-x: auto; }

.ps-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Manrope', sans-serif;
}
.ps-table thead th {
    padding: 10px 18px;
    font-size: 12.5px;
    font-weight: 700;
    color: #374151;
    text-align: left;
    background: #FAFAFA;
    border-bottom: 1px solid #F3F4F6;
    white-space: nowrap;
}
.ps-table thead th:first-child { padding-left: 20px; }
.ps-table thead th:last-child  { padding-right: 20px; }

.ps-table tbody tr {
    border-bottom: 1px solid #F9FAFB;
    transition: background 0.12s;
}
.ps-table tbody tr:last-child { border-bottom: none; }
.ps-table tbody tr:hover { background: #F9FAFB; }

.ps-table tbody td {
    padding: 10px 18px;
    font-size: 13.5px;
    color: #111827;
    vertical-align: middle;
}
.ps-table tbody td:first-child { padding-left: 20px; }
.ps-table tbody td:last-child  { padding-right: 20px; }

/* Cow cell */
.ps-cow-cell { display: flex; align-items: center; gap: 10px; }
.ps-cow-thumb {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: #124827;
    flex-shrink: 0;
}
.ps-cow-thumb--alt1 { background: #1B4332; }
.ps-cow-thumb--alt2 { background: #2D6A4F; }
.ps-cow-thumb--brown { background: #8B5E3C; }

.ps-cow-name { font-size: 13.5px; font-weight: 700; color: #111827; margin: 0 0 1px; line-height: 1.2; }
.ps-cow-id   { font-size: 11.5px; font-weight: 400; color: #9CA3AF; margin: 0; line-height: 1.2; }

.ps-liter       { font-size: 13.5px; font-weight: 700; color: #111827; }
.ps-liter--empty { color: #D1D5DB; }

.ps-status--done  { font-size: 13.5px; font-weight: 700; color: #124827; }
.ps-status--belum { font-size: 13.5px; font-weight: 700; color: #EF0000; }

.ps-edit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: opacity 0.15s;
}
.ps-edit-btn:hover { opacity: 0.7; }
.ps-edit-btn img { width: 20px; height: 20px; }

/* Edit modal styling */
.obs-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.obs-modal-content {
    animation: obs-modal-fade 0.25s ease-out;
}
@keyframes obs-modal-fade {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ── Pagination ───────────────────────────────────────────── */
.ps-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px 13px;
    border-top: 1px solid #F3F4F6;
    gap: 10px;
    flex-wrap: wrap;
}
.ps-pagination-info { font-size: 12.5px; font-weight: 600; color: #6B7280; white-space: nowrap; }
.ps-pagination-nav  { display: flex; align-items: center; gap: 3px; }

.ps-page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    height: 30px;
    padding: 0 5px;
    border-radius: 7px;
    border: 1.5px solid #E5E7EB;
    background: #FFFFFF;
    font-size: 12.5px;
    font-weight: 700;
    color: #374151;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: all 0.15s;
    line-height: 1;
}
.ps-page-btn:hover:not(:disabled):not(.ps-page-btn--active) { background: #F3F4F6; border-color: #D1D5DB; transform: translateY(-1px); }
.ps-page-btn--active { background: #124827; border-color: #124827; color: #FFFFFF; cursor: default; }
.ps-page-btn--arrow  { font-size: 14px; font-weight: 900; }
.ps-page-btn--arrow:disabled { opacity: 0.3; cursor: not-allowed; }
.ps-page-btn--ellipsis { border-color: transparent; background: transparent; cursor: default; color: #9CA3AF; }
.ps-page-btn--ellipsis:hover { background: transparent; transform: none; }

/* ── Bottom row ────────────────────────────────── */
.ps-bottom {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 16px;
    margin-top: 16px;
}

/* Chart card */
.ps-chart-card {
    background: #FFFFFF;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    border: 1px solid #E2E8F0;
    padding: 18px 20px 16px;
    display: flex;
    flex-direction: column;
}
.ps-chart-card__title {
    font-size: 14px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 14px;
}
.ps-chart-card__title span { font-weight: 500; color: #6B7280; font-size: 12.5px; }
.ps-chart-wrap { position: relative; flex: 1; min-height: 180px; height: 180px; }

/* Ringkasan */
.ps-ringkasan-card {
    background: #FFFFFF;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    border: 1px solid #E2E8F0;
    padding: 22px 24px 20px;
}
.ps-ringkasan-card__title { font-size: 15px; font-weight: 800; color: #111827; margin: 0 0 14px; }

.ps-ringkasan-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #F3F4F6;
    gap: 10px;
}
.ps-ringkasan-row:last-child { border-bottom: none; }
.ps-ringkasan-row__label { font-size: 13.5px; font-weight: 500; color: #6B7280; }
.ps-ringkasan-row__value { font-size: 14.5px; font-weight: 800; color: #111827; white-space: nowrap; }

/* Responsive */
@media (max-width: 1100px) { .ps-bottom { grid-template-columns: 1fr; } }
@media (max-width: 1200px) {
    .ps-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .ps-stats { grid-template-columns: 1fr; }
}
</style>
@endpush


@section('content')

{{-- ── STAT CARDS ── --}}
<div class="ps-stats">

    {{-- Total Sapi --}}
    <div class="ps-stat-card ps-stat-card--dark">
        <div class="ps-stat-icon-wrap">
            <img src="{{ Vite::asset('resources/images/icons/iconsapihijaucarddashboard.svg') }}" alt="Total Sapi">
        </div>
        <div class="ps-stat-content">
            <div class="ps-stat-value">{{ $totalSapi }}</div>
            <span class="ps-stat-label">Total Sapi</span>
            <span class="ps-stat-sub">Semua Sapi</span>
        </div>
    </div>

    {{-- Sapi Sehat --}}
    <div class="ps-stat-card ps-stat-card--green">
        <div class="ps-stat-icon-wrap">
            <img src="{{ Vite::asset('resources/images/icons/tamengplus.svg') }}" alt="Sapi Sehat">
        </div>
        <div class="ps-stat-content">
            <div class="ps-stat-value">{{ $sapiSehat }}</div>
            <span class="ps-stat-label">Sapi Sehat</span>
            <span class="ps-stat-sub">{{ $persenSehat }} %</span>
        </div>
    </div>

    {{-- Sudah Diperah --}}
    {{-- Sudah Diperah --}}
    <div class="ps-stat-card ps-stat-card--blue">
        <div class="ps-stat-icon-wrap">
            <img src="{{ Vite::asset('resources/images/icons/iconsusunyasapi.svg') }}" alt="Sudah Diperah">
        </div>
        <div class="ps-stat-content">
            <div class="ps-stat-value" id="stat-sudah-diperah">{{ $sudahDiperah }}</div>
            <span class="ps-stat-label">Sudah Diperah<br>Hari ini</span>
            <span class="ps-stat-sub" style="color: #2563EB;" id="stat-sudah-diperah-pct">{{ $persenDiperah }} %</span>
        </div>
    </div>

    {{-- Terjual --}}
    <div class="ps-stat-card ps-stat-card--purple">
        <div class="ps-stat-icon-wrap">
            <img src="{{ Vite::asset('resources/images/icons/icondogtag.svg') }}" alt="Terjual">
        </div>
        <div class="ps-stat-content">
            <div class="ps-stat-value">{{ number_format($terjualHariIniVolume, 0, ',', '.') }}<span class="ps-stat-unit" style="font-size: 28px; font-weight: 800; vertical-align: baseline; margin-left: 2px;">L</span></div>
            <span class="ps-stat-label">Terjual Hari Ini</span>
            <span class="ps-stat-sub" style="color: #111827;">Rp {{ number_format($terjualHariIniPendapatan, 0, ',', '.') }}</span>
        </div>
    </div>

</div>

{{-- ── MAIN TABS & FILTER OUTSIDE ── --}}
<div class="ps-tabs-bar" style="display: flex; align-items: center; justify-content: space-between; padding: 0 0 16px; gap: 12px; margin-top: 10px;">
    <div class="ps-tabs" role="tablist" style="display: flex; gap: 16px;">
        <button class="ps-tab ps-tab--active" id="tab-pagi"
                role="tab" aria-selected="true"
                onclick="setSession(this,'pagi')">Pagi</button>
        <button class="ps-tab ps-tab--inactive" id="tab-sore"
                role="tab" aria-selected="false"
                onclick="setSession(this,'sore')">Sore</button>
    </div>
    <button class="ps-filter-btn" id="btn-filter" aria-label="Filter">
        <img src="{{ Vite::asset('resources/images/icons/iconfilter.svg') }}" alt="Filter">
        Filter
    </button>
</div>

{{-- ── MAIN TABLE CARD ──────────────────────────────────────── --}}
<div class="ps-card" style="margin-top: 0;">
    <div class="ps-table-wrap">
        <table class="ps-table" id="ps-table" aria-label="Data produksi susu">
            <thead>
                <tr>
                    <th scope="col">Daftar Sapi</th>
                    <th scope="col">Pagi (Liter)</th>
                    <th scope="col">Sore (Liter)</th>
                    <th scope="col">Total (Liter)</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="ps-tbody">

                @forelse($sapis as $sapi)
                    @php
                        $pagi = $sapi->produksi->where('sesi', 'pagi')->first()?->jumlah_susu;
                        $sore = $sapi->produksi->where('sesi', 'sore')->first()?->jumlah_susu;
                        $total = ($pagi ?? 0) + ($sore ?? 0);
                        
                        $sessionAttr = 'none';
                        if (!is_null($pagi) && !is_null($sore)) {
                            $sessionAttr = 'both';
                        } elseif (!is_null($pagi)) {
                            $sessionAttr = 'pagi';
                        } elseif (!is_null($sore)) {
                            $sessionAttr = 'sore';
                        }

                        $statusText = (!is_null($pagi) || !is_null($sore)) ? 'Sudah' : 'Belum';
                    @endphp
                    <tr class="ps-row" data-session="{{ $sessionAttr }}" data-pagi="{{ $pagi ?? '' }}" data-sore="{{ $sore ?? '' }}" data-total="{{ $total ?? 0 }}" data-name="{{ $sapi->name }}" data-code="{{ $sapi->code }}">
                        <td>
                            <div class="ps-cow-cell">
                                <img src="{{ Vite::asset('resources/images/icons/icondatasapi.svg') }}" alt="" style="width: 32px; height: 32px; object-fit: contain;">
                                <div>
                                    <div style="font-size: 16px; font-weight: 800; color: #111827; margin-bottom: 2px;">{{ $sapi->name }}</div>
                                    <div style="font-size: 13px; font-weight: 600; color: #9CA3AF;">({{ $sapi->code }})</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="ps-liter">{{ !is_null($pagi) ? $pagi . ' L' : '—' }}</span></td>
                        <td><span class="ps-liter">{{ !is_null($sore) ? $sore . ' L' : '—' }}</span></td>
                        <td><span class="ps-liter">{{ $total > 0 ? $total . 'L' : '—' }}</span></td>
                        <td>
                            <span class="@if($statusText === 'Sudah') ps-status--done @else ps-status--belum @endif">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="ps-edit-btn" onclick="openEditProduksiModal({{ $sapi->id }}, '{{ $pagi ?? '' }}', '{{ $sore ?? '' }}')">
                                <img src="{{ Vite::asset('resources/images/icons/iconedit.svg') }}" alt="Edit">
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="ps-empty-row" style="display: none;">
                        <td colspan="6">
                            <div style="text-align:center; padding:40px; color:#9CA3AF;">
                                Belum ada data sapi terdaftar.
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <div class="ps-pagination-bar" id="ps-pagination-bar">
        <span class="ps-pagination-info" id="ps-pagination-info">Menampilkan 0 - 0 dari 0 Data</span>
        <nav class="ps-pagination-nav" id="ps-pagination-nav" aria-label="Navigasi halaman"></nav>
    </div>

</div>

{{-- ── BOTTOM ROW ───────────────────────────────────────────── --}}
<div class="ps-bottom">

    <div class="ps-chart-card">
        <p class="ps-chart-card__title">Produksi Susu <span>(7 Hari Terakhir)</span></p>
        <div class="ps-chart-wrap">
            <canvas id="ps-chart"></canvas>
        </div>
    </div>

    <div class="ps-ringkasan-card">
        <p class="ps-ringkasan-card__title">Ringkasan Produksi</p>
        <div class="ps-ringkasan-row">
            <span class="ps-ringkasan-row__label">Total</span>
            <span class="ps-ringkasan-row__value" id="summary-total">{{ number_format($totalProduksiHariIni, 1, ',', '.') }} Liter</span>
        </div>
        <div class="ps-ringkasan-row">
            <span class="ps-ringkasan-row__label">Rata rata per sapi</span>
            <span class="ps-ringkasan-row__value" id="summary-avg">{{ number_format($rataRataPerSapi, 1, ',', '.') }} Liter</span>
        </div>
        <div class="ps-ringkasan-row">
            <span class="ps-ringkasan-row__label">Tertinggi</span>
            <span class="ps-ringkasan-row__value" id="summary-highest">
                {{ $highestCowProd ? $highestCowProd->sapi->name . ' (' . round($highestCowProd->total_susu) . ' Liter)' : '—' }}
            </span>
        </div>
        <div class="ps-ringkasan-row">
            <span class="ps-ringkasan-row__label">Terendah</span>
            <span class="ps-ringkasan-row__value" id="summary-lowest">
                {{ $lowestCowProd ? $lowestCowProd->sapi->name . ' (' . round($lowestCowProd->total_susu) . ' Liter)' : '—' }}
            </span>
        </div>
        <div class="ps-ringkasan-row">
            <span class="ps-ringkasan-row__label">Belum Diperah</span>
            <span class="ps-ringkasan-row__value" id="summary-unmilked" style="color:#DC2626;">{{ $belumDiperahCount }} Sapi</span>
        </div>
    </div>

</div>

{{-- Modal Form Edit Produksi --}}
<div id="produksiModal" class="obs-modal-overlay" style="display: none;">
    <div class="obs-modal-content" style="background: #D9D9D9; border: 1px solid #7F7F7F; border-radius: 12px; max-width: 380px; padding: 24px; width: 100%; box-sizing: border-box; font-family: 'Manrope', sans-serif;">
        <div class="obs-modal-header" style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
            <h3 class="obs-modal-title" style="font-size: 16.5px; font-weight: 800; color: #000000; display: flex; align-items: center; gap: 8px; margin: 0;">
                <img src="{{ Vite::asset('resources/images/icons/iconpensil2.svg') }}" style="width:16px; height:16px;" alt="">
                Edit Produksi Susu
            </h3>
            <button type="button" class="obs-modal-close" onclick="closeProduksiModal()" style="font-size: 20px; font-weight: 900; color: #000000; border: none; background: none; cursor: pointer; padding: 0; line-height: 1;">X</button>
        </div>
        <form action="{{ route('owner.produksi.store') }}" method="POST">
            @csrf
            
            <!-- Tanggal -->
            <div class="obs-form-group" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #6B7280; margin-bottom: 6px; display: block;">Tanggal</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <img src="{{ Vite::asset('resources/images/icons/icon kalender.svg') }}" style="position: absolute; left: 14px; width: 18px; height: 18px; pointer-events: none;" alt="">
                    <input type="date" name="tanggal" id="prodTanggal" style="padding: 10px 14px 10px 42px; border: 1.5px solid #D1D5DB; border-radius: 8px; font-size: 14px; font-weight: 700; font-family: 'Manrope', sans-serif; color: #111827; background: #FFFFFF; width: 100%; box-sizing: border-box;">
                </div>
            </div>

            <!-- Sesi -->
            <div class="obs-form-group" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #6B7280; margin-bottom: 6px; display: block;">Sesi</label>
                <div style="display: flex; gap: 12px;">
                    <label style="flex: 1; display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border: 1.5px solid #D1D5DB; border-radius: 8px; background: #FFFFFF; cursor: pointer; user-select: none;">
                        <span style="font-size: 14px; font-weight: 700; color: #111827; display: flex; align-items: center; gap: 8px;">
                            <img src="{{ Vite::asset('resources/images/icons/iconmatahari.svg') }}" style="width: 18px; height: 18px;" alt="">
                            Pagi
                        </span>
                        <input type="radio" name="sesi" value="pagi" id="prodSesiPagi" style="display: none;" onchange="updateSessionRadioDots()">
                        <span id="dotPagi" style="width: 16px; height: 16px; border: 1.5px solid #9CA3AF; border-radius: 50%; display: inline-block; box-sizing: border-box; transition: all 0.15s;"></span>
                    </label>
                    <label style="flex: 1; display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border: 1.5px solid #D1D5DB; border-radius: 8px; background: #FFFFFF; cursor: pointer; user-select: none;">
                        <span style="font-size: 14px; font-weight: 700; color: #111827; display: flex; align-items: center; gap: 8px;">
                            <img src="{{ Vite::asset('resources/images/icons/iconbulan.svg') }}" style="width: 18px; height: 18px;" alt="">
                            Sore
                        </span>
                        <input type="radio" name="sesi" value="sore" id="prodSesiSore" style="display: none;" onchange="updateSessionRadioDots()">
                        <span id="dotSore" style="width: 16px; height: 16px; border: 1.5px solid #9CA3AF; border-radius: 50%; display: inline-block; box-sizing: border-box; transition: all 0.15s;"></span>
                    </label>
                </div>
            </div>

            <!-- Pilih Sapi Dropdown -->
            <div class="obs-form-group" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #6B7280; margin-bottom: 6px; display: block;">Pilih Sapi</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <img src="{{ Vite::asset('resources/images/icons/icondatasapi.svg') }}" style="position: absolute; left: 14px; width: 18px; height: 18px; pointer-events: none; object-fit: contain;" alt="">
                    <select name="sapi_id" id="prodSapiSelect" style="padding: 10px 14px 10px 42px; border: 1.5px solid #D1D5DB; border-radius: 8px; font-size: 14px; font-weight: 700; font-family: 'Manrope', sans-serif; color: #111827; background: #FFFFFF; width: 100%; box-sizing: border-box; appearance: none; -webkit-appearance: none; cursor: pointer;">
                        @foreach($sapis as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->code }})</option>
                        @endforeach
                    </select>
                    <span style="position: absolute; right: 14px; font-size: 14px; font-weight: 800; color: #111827; pointer-events: none; line-height: 1;">∨</span>
                </div>
            </div>

            <!-- Jumlah Susu (Liter) -->
            <div class="obs-form-group" style="margin-bottom: 20px;">
                <label style="font-size: 13px; font-weight: 700; color: #6B7280; margin-bottom: 6px; display: block;">Jumlah Susu (Liter)</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="number" step="0.1" name="jumlah_susu" id="prodJumlahSusu" placeholder="Masukkan jumlah susu" style="padding: 10px 40px 10px 14px; border: 1.5px solid #D1D5DB; border-radius: 8px; font-size: 14px; font-weight: 700; font-family: 'Manrope', sans-serif; color: #111827; background: #FFFFFF; width: 100%; box-sizing: border-box;" required>
                    <span style="position: absolute; right: 14px; font-size: 14px; font-weight: 800; color: #111827; pointer-events: none;">L</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="obs-form-actions" style="margin-top: 20px; display: flex; gap: 12px;">
                <button type="button" class="obs-btn-cancel" onclick="closeProduksiModal()" style="flex: 1; padding: 10px 20px; border: 1.5px solid #D1D5DB; background: #FFFFFF; color: #111827; font-size: 14px; font-weight: 700; border-radius: 8px; cursor: pointer; text-align: center;">Batal</button>
                <button type="submit" class="obs-btn-save" style="flex: 1.2; padding: 10.5px 20px; border: none; background: #124827; color: #FFFFFF; font-size: 14px; font-weight: 700; border-radius: 8px; cursor: pointer; text-align: center;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    /* ── Pagination ───────────────────────────────────────────── */
    const PER_PAGE = 4;
    let currentPage = 1;
    let currentSession = 'pagi';

    const allRows = Array.from(document.querySelectorAll('#ps-tbody tr.ps-row'));
    const infoEl  = document.getElementById('ps-pagination-info');
    const navEl   = document.getElementById('ps-pagination-nav');

    function getVisible() {
        return allRows.filter(r => {
            const s = r.dataset.session;
            if (currentSession === 'pagi') return s === 'pagi' || s === 'both';
            if (currentSession === 'sore') return s === 'sore' || s === 'both';
            return true;
        });
    }

    function updateProduksiStats() {
        const totalSapi = allRows.length;
        
        let countMilked = 0;
        let sumSusu = 0;
        let highestVol = -1;
        let highestName = '—';
        let lowestVol = Infinity;
        let lowestName = '—';

        allRows.forEach(row => {
            const pagi = parseFloat(row.dataset.pagi) || 0;
            const sore = parseFloat(row.dataset.sore) || 0;
            
            let val = 0;
            let isMilked = false;

            if (currentSession === 'pagi') {
                val = pagi;
                isMilked = pagi > 0;
            } else if (currentSession === 'sore') {
                val = sore;
                isMilked = sore > 0;
            } else {
                val = pagi + sore;
                isMilked = (pagi > 0 || sore > 0);
            }

            if (isMilked) {
                countMilked++;
                sumSusu += val;

                if (val > highestVol) {
                    highestVol = val;
                    highestName = `${row.dataset.name} (${val} Liter)`;
                }
                if (val < lowestVol) {
                    lowestVol = val;
                    lowestName = `${row.dataset.name} (${val} Liter)`;
                }
            }
        });

        if (lowestVol === Infinity) {
            lowestName = '—';
        }

        const avgSusu = countMilked > 0 ? (sumSusu / countMilked).toFixed(1) : '0';
        const unmilkedCount = totalSapi - countMilked;
        const percentMilked = totalSapi > 0 ? Math.round((countMilked / totalSapi) * 100) : 0;

        // Update Stat Card 3 (Sudah Diperah)
        const statMilked = document.getElementById('stat-sudah-diperah');
        if (statMilked) statMilked.textContent = countMilked.toString();
        const statMilkedPct = document.getElementById('stat-sudah-diperah-pct');
        if (statMilkedPct) statMilkedPct.textContent = `${percentMilked} %`;

        // Update Ringkasan Produksi Card
        const sumTotal = document.getElementById('summary-total');
        if (sumTotal) sumTotal.textContent = `${sumSusu.toLocaleString('id-ID')} Liter`;
        const sumAvg = document.getElementById('summary-avg');
        if (sumAvg) sumAvg.textContent = `${avgSusu.replace('.', ',')} Liter`;
        const sumHighest = document.getElementById('summary-highest');
        if (sumHighest) sumHighest.textContent = highestName;
        const sumLowest = document.getElementById('summary-lowest');
        if (sumLowest) sumLowest.textContent = lowestName;
        const sumUnmilked = document.getElementById('summary-unmilked');
        if (sumUnmilked) {
            sumUnmilked.textContent = `${unmilkedCount} Sapi`;
            sumUnmilked.style.color = unmilkedCount > 0 ? '#EF4444' : '#111827';
        }
    }

    function render() {
        const visible    = getVisible();
        const total      = visible.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * PER_PAGE;
        const end   = Math.min(start + PER_PAGE, total);

        allRows.forEach(r => r.style.display = 'none');
        visible.forEach((r, i) => r.style.display = (i >= start && i < end) ? '' : 'none');

        // Handle empty row
        const emptyRow = document.getElementById('ps-empty-row');
        if (emptyRow) {
            emptyRow.style.display = total === 0 ? '' : 'none';
        }

        infoEl.textContent = total === 0
            ? 'Tidak ada data'
            : `Menampilkan ${start + 1} - ${end} dari ${total} Data`;

        navEl.innerHTML = '';
        function btn(label, page, cls, disabled) {
            const b = document.createElement('button');
            b.className = 'ps-page-btn ' + (cls || '');
            b.textContent = label;
            b.setAttribute('aria-label', label);
            if (disabled) b.disabled = true;
            if (page !== null && !disabled) b.addEventListener('click', () => { currentPage = page; render(); });
            navEl.appendChild(b);
        }

        btn('\u2039', currentPage - 1, 'ps-page-btn--arrow', currentPage === 1);
        const delta = 1;
        let pages = [];
        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentPage - delta && p <= currentPage + delta)) pages.push(p);
        }
        let prev = null;
        pages.forEach(p => {
            if (prev !== null && p - prev > 1) {
                const e = document.createElement('button');
                e.className = 'ps-page-btn ps-page-btn--ellipsis';
                e.textContent = '...'; e.disabled = true;
                navEl.appendChild(e);
            }
            btn(p, p, p === currentPage ? 'ps-page-btn--active' : '', false);
            prev = p;
        });
        btn('\u203A', currentPage + 1, 'ps-page-btn--arrow', currentPage === totalPages || total === 0);

        // Update stats card dynamically on render!
        updateProduksiStats();
    }

    /* ── Tab switching ────────────────────────────────────────── */
    function setSession(el, session) {
        currentSession = session;
        currentPage    = 1;
        document.querySelectorAll('.ps-tab').forEach(t => {
            t.classList.remove('ps-tab--active');
            t.classList.add('ps-tab--inactive');
            t.setAttribute('aria-selected', 'false');
        });
        el.classList.remove('ps-tab--inactive');
        el.classList.add('ps-tab--active');
        el.setAttribute('aria-selected', 'true');
        render();
    }
    window.setSession = setSession;

    function updateSessionRadioDots() {
        const pagiRadio = document.getElementById('prodSesiPagi');
        const soreRadio = document.getElementById('prodSesiSore');
        const dotPagi = document.getElementById('dotPagi');
        const dotSore = document.getElementById('dotSore');

        if (pagiRadio.checked) {
            dotPagi.style.background = '#124827';
            dotPagi.style.borderColor = '#124827';
            dotSore.style.background = 'transparent';
            dotSore.style.borderColor = '#9CA3AF';
        } else if (soreRadio.checked) {
            dotSore.style.background = '#124827';
            dotSore.style.borderColor = '#124827';
            dotPagi.style.background = 'transparent';
            dotPagi.style.borderColor = '#9CA3AF';
        }
    }
    window.updateSessionRadioDots = updateSessionRadioDots;

    window.openEditProduksiModal = function(sapiId, pagiVal, soreVal) {
        document.getElementById('prodSapiSelect').value = sapiId;

        // Set date to the currently selected date
        const activeDateStr = "{{ $selectedDate->format('Y-m-d') }}";
        document.getElementById('prodTanggal').value = activeDateStr;

        if (currentSession === 'pagi') {
            document.getElementById('prodSesiPagi').checked = true;
            document.getElementById('prodJumlahSusu').value = pagiVal;
        } else {
            document.getElementById('prodSesiSore').checked = true;
            document.getElementById('prodJumlahSusu').value = soreVal;
        }

        updateSessionRadioDots();
        document.getElementById('produksiModal').style.display = 'flex';
    };

    window.closeProduksiModal = function() {
        document.getElementById('produksiModal').style.display = 'none';
    };

    render();

    /* ── Area chart ───────────────────────────────────────────── */
    const ctx = document.getElementById('ps-chart').getContext('2d');
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
})();</script>
@endpush
