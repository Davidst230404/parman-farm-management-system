@extends('layouts.owner')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('page-subtitle', 'Rekapitulasi data peternakan dan ekspor laporan')

@push('styles')
<style>
/* ============================================================
   Laporan | Owner Page CSS — Figma Node 97-703
   ============================================================ */

/* ── Top Header Title & Export Buttons ─────────────────────── */
.lr-header-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 16px;
    flex-wrap: wrap;
}
.lr-header-title {
    display: flex;
    flex-direction: column;
}
.lr-header-title h2 {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 4px 0;
}
.lr-header-title p {
    font-size: 13.5px;
    font-weight: 500;
    color: #6B7280;
    margin: 0;
}
.lr-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.lr-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 42px;
    padding: 0 18px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    font-family: 'Manrope', sans-serif;
    cursor: pointer;
    transition: all 0.15s;
    border: none;
    user-select: none;
}
.lr-btn--excel {
    background: #124827;
    color: #FFFFFF;
}
.lr-btn--excel:hover {
    background: #0e3a1f;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(18, 72, 39, 0.2);
}
.lr-btn--secondary {
    background: #FFFFFF;
    border: 1.5px solid #D1D5DB;
    color: #374151;
}
.lr-btn--secondary:hover {
    background: #F9FAFB;
    border-color: #9CA3AF;
}
.lr-btn img {
    width: 16px;
    height: 16px;
}

/* ── Filter Laporan Card ───────────────────────────────────── */
.lr-filter-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}
.lr-filter-card__title {
    font-size: 14.5px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 16px 0;
}
.lr-filter-grid {
    display: grid;
    grid-template-columns: 2fr 1.2fr 1.2fr 1.6fr;
    gap: 16px;
    align-items: flex-end;
}
.lr-filter-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.lr-filter-label {
    font-size: 12.5px;
    font-weight: 700;
    color: #4B5563;
}
.lr-date-range {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #F9FAFB;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    padding: 0 12px;
    height: 42px;
}
.lr-date-range input {
    border: none;
    background: transparent;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    font-family: 'Manrope', sans-serif;
    outline: none;
    width: 100%;
    cursor: pointer;
}
.lr-date-range img {
    width: 16px;
    height: 16px;
    opacity: 0.6;
}
.lr-filter-sep {
    font-size: 13px;
    font-weight: 700;
    color: #9CA3AF;
}
.lr-filter-select {
    height: 42px;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    padding: 0 34px 0 12px;
    font-size: 13.5px;
    font-weight: 700;
    color: #374151;
    font-family: 'Manrope', sans-serif;
    background: #FFFFFF url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
    -webkit-appearance: none;
    appearance: none;
    outline: none;
    cursor: pointer;
}
.lr-filter-actions {
    display: flex;
    gap: 8px;
}
.lr-filter-actions .lr-btn {
    flex: 1;
}

/* ── Stat Cards ────────────────────────────────── */
.lr-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}
.lr-stat-card {
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
.lr-stat-card:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.09);
    transform: translateY(-2px);
}
.lr-stat-icon {
    grid-area: icon;
    width: 56px !important;
    height: 56px !important;
    object-fit: contain;
    justify-self: start;
}
.lr-stat-content {
    display: contents !important;
}
.lr-stat-value {
    grid-area: value;
    font-size: 26px !important;
    font-weight: 800;
    line-height: 1.1;
    margin: 0;
    align-self: center;
    justify-self: start;
    text-align: left;
    white-space: nowrap;
}
.lr-stat-label {
    grid-area: label;
    font-size: 13.5px !important;
    font-weight: 700;
    color: #4B5563;
    margin: 4px 0 0 0 !important;
    line-height: 1.3;
}
.lr-stat-sub {
    grid-area: sub;
    font-size: 13px !important;
    font-weight: 700;
    margin: 2px 0 0 0 !important;
    line-height: 1.3;
}

/* ── Preview Data Card & Table ────────────────────────────── */
.lr-table-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}
.lr-table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #E5E7EB;
}
.lr-table-title {
    font-size: 14.5px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}
.lr-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Manrope', sans-serif;
}
.lr-table thead th {
    padding: 12px 20px;
    font-size: 12.5px;
    font-weight: 700;
    color: #374151;
    text-align: left;
    background: #FAFAFA;
    border-bottom: 1px solid #E5E7EB;
    white-space: nowrap;
}
.lr-table tbody tr {
    border-bottom: 1px solid #F3F4F6;
    transition: background 0.1s;
}
.lr-table tbody tr:last-child { border-bottom: none; }
.lr-table tbody tr:hover { background: #F9FAFB; }

.lr-table tbody td {
    padding: 14px 20px;
    font-size: 13.5px;
    color: #111827;
    vertical-align: middle;
}
.lr-table tbody td.lr-bold {
    font-weight: 700;
}

/* Status Badges */
.lr-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 24px;
    padding: 0 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
}
.lr-badge--selesai {
    background: #DEF7EC;
    color: #03543F;
}
.lr-badge--pending {
    background: #FEF3C7;
    color: #92400E;
}

/* Pagination Bar */
.lr-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-top: 1px solid #E5E7EB;
    gap: 12px;
}
.lr-pagination-info {
    font-size: 12.5px;
    font-weight: 600;
    color: #6B7280;
}
.lr-pagination-nav {
    display: flex;
    align-items: center;
    gap: 4px;
}
.lr-page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 4px;
    border-radius: 6px;
    border: 1.5px solid #E5E7EB;
    background: #FFFFFF;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: all 0.15s;
}
.lr-page-btn:hover:not(:disabled):not(.lr-page-btn--active) {
    background: #F3F4F6;
    border-color: #D1D5DB;
}
.lr-page-btn--active {
    background: #124827;
    border-color: #124827;
    color: #FFFFFF;
    cursor: default;
}
.lr-page-btn--ellipsis {
    border-color: transparent;
    background: transparent;
    cursor: default;
    color: #9CA3AF;
}

/* Alert Banner */
.lr-alert-banner {
    position: fixed;
    top: 24px;
    right: 24px;
    background: #124827;
    color: #FFFFFF;
    padding: 14px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    z-index: 1100;
    font-size: 13.5px;
    font-weight: 700;
    display: none;
    align-items: center;
    gap: 10px;
    animation: lrAlertSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes lrAlertSlideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Responsive */
@media (max-width: 1200px) {
    .lr-filter-grid { grid-template-columns: 1fr 1fr; }
    .lr-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .lr-filter-grid { grid-template-columns: 1fr; }
    .lr-stats { grid-template-columns: 1fr; }
}

/* Hybrid Searchable Dropdown Styles */
.hybrid-select-wrapper {
    position: relative;
    width: 100%;
}
.hybrid-select-display {
    width: 100%;
    padding: 10px 34px 10px 12px;
    border: 1.5px solid #E5E7EB; /* match theme */
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    color: #374151;
    background: #FFFFFF;
    box-sizing: border-box;
    cursor: pointer;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    position: relative;
    font-family: 'Manrope', sans-serif;
    height: 42px;
    line-height: 20px;
}
.hybrid-select-display::after {
    content: "∨";
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    font-weight: 800;
    color: #9CA3AF;
    pointer-events: none;
}
.hybrid-select-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #FFFFFF;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    z-index: 999;
    margin-top: 4px;
    padding: 8px;
    box-sizing: border-box;
}
.hybrid-select-search {
    width: 100%;
    padding: 8px 12px;
    border: 1.5px solid #E5E7EB;
    border-radius: 6px;
    font-size: 13.5px;
    font-family: 'Manrope', sans-serif;
    margin-bottom: 8px;
    box-sizing: border-box;
    font-weight: 600;
}
.hybrid-select-search:focus {
    outline: none;
    border-color: #124827;
}
.hybrid-select-options {
    max-height: 200px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.hybrid-select-option {
    padding: 8px 12px;
    font-size: 13.5px;
    color: #374151;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.15s, color 0.15s;
    font-family: 'Manrope', sans-serif;
    font-weight: 600;
    text-align: left;
}
.hybrid-select-option:hover {
    background: #124827;
    color: #FFFFFF;
}
.hybrid-select-option--selected {
    background: #F3F4F6;
    color: #124827;
}
.hybrid-select-option--hidden {
    display: none;
}
.hybrid-select-no-results {
    padding: 8px 12px;
    font-size: 13.5px;
    color: #9CA3AF;
    text-align: center;
    font-family: 'Manrope', sans-serif;
}
</style>
@endpush


@section('content')

<div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
    <button class="lr-btn lr-btn--excel" id="btn-export-excel" style="background: #124827; border: none; color: #FFFFFF; font-weight: 700; border-radius: 8px; height: 42px; padding: 0 20px; font-family: 'Manrope', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Export Excel
    </button>
</div>

{{-- ============================================================
     FILTER LAPORAN CARD
     ============================================================ --}}
<div class="lr-filter-card" style="background: #FFFFFF; border-radius: 12px; border: 1.5px solid #E5E7EB; padding: 24px; box-sizing: border-box; font-family: 'Manrope', sans-serif; margin-bottom: 24px;">
    <h3 class="lr-filter-card__title" style="font-size: 16px; font-weight: 800; color: #111827; margin: 0 0 20px 0;">Filter Laporan</h3>
    
    <!-- Filter Grid for horizontal inputs -->
    <div style="display: flex; gap: 24px; align-items: flex-end; margin-bottom: 20px; flex-wrap: wrap;">
        
        <!-- Periode -->
        <div class="lr-filter-field" style="display: flex; flex-direction: column; gap: 6px; min-width: 340px;">
            <span class="lr-filter-label" style="font-size: 13px; font-weight: 700; color: #374151;">Periode</span>
            <div style="display: flex; align-items: center; gap: 10px; width: 100%;">
                
                <!-- Tanggal Mulai Card Picker -->
                <div style="position: relative; display: flex; align-items: center; background: #FFFFFF; border: 1.5px solid #D1D5DB; border-radius: 8px; height: 42px; padding: 0 14px; box-sizing: border-box; flex: 1; cursor: pointer;">
                    <span id="label-start-date" style="font-weight: 700; color: #111827; font-size: 13.5px;">{{ Carbon\Carbon::today()->subDays(6)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                    <input type="date" id="filter-start-date" value="{{ Carbon\Carbon::today()->subDays(6)->format('Y-m-d') }}" style="position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;">
                    <img src="{{ asset('images/icons/icon kalender.svg') }}" style="position: absolute; right: 14px; width: 18px; height: 18px; pointer-events: none;" alt="">
                </div>
                
                <span class="lr-filter-sep" style="font-size: 13px; font-weight: 700; color: #374151;">sd</span>
                
                <!-- Tanggal Selesai Card Picker -->
                <div style="position: relative; display: flex; align-items: center; background: #FFFFFF; border: 1.5px solid #D1D5DB; border-radius: 8px; height: 42px; padding: 0 14px; box-sizing: border-box; flex: 1; cursor: pointer;">
                    <span id="label-end-date" style="font-weight: 700; color: #111827; font-size: 13.5px;">{{ Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                    <input type="date" id="filter-end-date" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" style="position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;">
                    <img src="{{ asset('images/icons/icon kalender.svg') }}" style="position: absolute; right: 14px; width: 18px; height: 18px; pointer-events: none;" alt="">
                </div>
                
            </div>
        </div>

        <!-- Jenis Laporan -->
        <div class="lr-filter-field" style="display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 180px;">
            <label class="lr-filter-label" for="filter-report-type" style="font-size: 13px; font-weight: 700; color: #374151;">Jenis Laporan</label>
            <div style="position: relative; display: flex; align-items: center;">
                <select class="lr-filter-select" id="filter-report-type" style="width: 100%; border: 1.5px solid #D1D5DB; border-radius: 8px; height: 42px; padding: 0 36px 0 14px; font-weight: 700; font-family: 'Manrope', sans-serif; appearance: none; -webkit-appearance: none; background: #FFFFFF; font-size: 13.5px; cursor: pointer;">
                    <option value="Semua Data" selected>Semua Data</option>
                    <option value="Produksi Susu">Produksi Susu</option>
                    <option value="Penjualan Susu">Penjualan Susu</option>
                </select>
                <span style="position: absolute; right: 14px; font-size: 13px; font-weight: 900; color: #111827; pointer-events: none; line-height: 1;">▼</span>
            </div>
        </div>

        <!-- Mitra / Pembeli -->
        <div class="lr-filter-field" style="display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 180px;">
            <label class="lr-filter-label" for="filter-partner" style="font-size: 13px; font-weight: 700; color: #374151;">Mitra / Pembeli</label>
            <div style="position: relative; display: flex; align-items: center;">
                <select class="lr-filter-select" id="filter-partner" style="width: 100%; border: 1.5px solid #D1D5DB; border-radius: 8px; height: 42px; padding: 0 36px 0 14px; font-weight: 700; font-family: 'Manrope', sans-serif; appearance: none; -webkit-appearance: none; background: #FFFFFF; font-size: 13.5px; cursor: pointer;">
                    <option value="Semua Mitra" selected>Semua Mitra</option>
                    @foreach($mitras as $m)
                        <option value="{{ $m->nama }}">{{ $m->nama }}</option>
                    @endforeach
                </select>
                <span style="position: absolute; right: 14px; font-size: 13px; font-weight: 900; color: #111827; pointer-events: none; line-height: 1;">▼</span>
            </div>
        </div>

    </div>

    <!-- Buttons row (aligned right at bottom) -->
    <div style="display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
        <button type="button" class="lr-btn" id="btn-reset-filter" style="background: #FFFFFF; border: 1.5px solid #D1D5DB; color: #124827; border-radius: 8px; height: 40px; padding: 0 20px; font-weight: 700; font-family: 'Manrope', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
            </svg>
            Reset
        </button>
        <button type="button" class="lr-btn" id="btn-submit-filter" style="background: #124827; border: none; color: #FFFFFF; border-radius: 8px; height: 40px; padding: 0 24px; font-weight: 700; font-family: 'Manrope', sans-serif; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">
            Tampilkan
        </button>
    </div>
</div>

{{-- ============================================================
     STAT CARDS (Cow, Leaf, Milk, Price Tag)
     ============================================================ --}}
<div class="lr-stats">

    @include('owner.components.stat-card', [
        'cardClass' => 'lr-stat-card',
        'iconClass' => 'lr-stat-icon',
        'contentClass' => 'lr-stat-content',
        'valueClass' => 'lr-stat-value',
        'labelClass' => 'lr-stat-label',
        'subClass' => 'lr-stat-sub',
        'icon' => 'resources/images/icons/iconsapihijaucarddashboard.svg',
        'value' => $totalSapi,
        'valueId' => 'stat-total-sapi',
        'valueStyle' => 'color: #124827;',
        'label' => 'Total Sapi',
        'sub' => 'Semua Sapi',
        'subStyle' => 'color: #6B7280; font-weight: 500;'
    ])

    @include('owner.components.stat-card', [
        'cardClass' => 'lr-stat-card',
        'iconClass' => 'lr-stat-icon',
        'contentClass' => 'lr-stat-content',
        'valueClass' => 'lr-stat-value',
        'labelClass' => 'lr-stat-label',
        'subClass' => 'lr-stat-sub',
        'icon' => 'resources/images/icons/tamengplus.svg',
        'value' => $sapiSehat,
        'valueId' => 'stat-sapi-sehat',
        'valueStyle' => 'color: #124827;',
        'label' => 'Sapi Sehat',
        'sub' => $persenSehat . ' %',
        'subStyle' => 'color: #124827; font-weight: 700;'
    ])

    @include('owner.components.stat-card', [
        'cardClass' => 'lr-stat-card',
        'iconClass' => 'lr-stat-icon',
        'contentClass' => 'lr-stat-content',
        'valueClass' => 'lr-stat-value',
        'labelClass' => 'lr-stat-label',
        'subClass' => 'lr-stat-sub',
        'icon' => 'resources/images/icons/iconbotolsusubiru.svg',
        'value' => number_format($produksiSusuBulanIni, 0, ',', '.') . '<span style="font-size: 28px; font-weight: 800; vertical-align: baseline; margin-left: 2px;">L</span>',
        'valueId' => 'stat-produksi-susu',
        'valueStyle' => 'color: #2563EB;',
        'label' => 'Produksi Susu',
        'sub' => 'Bulan Ini',
        'subStyle' => 'color: #2563EB; font-weight: 700;'
    ])

    @include('owner.components.stat-card', [
        'cardClass' => 'lr-stat-card',
        'iconClass' => 'lr-stat-icon',
        'contentClass' => 'lr-stat-content',
        'valueClass' => 'lr-stat-value',
        'labelClass' => 'lr-stat-label',
        'subClass' => 'lr-stat-sub',
        'icon' => 'resources/images/icons/icondogtag.svg',
        'value' => number_format($totalPenjualanBulanIni, 0, ',', '.'),
        'valueId' => 'stat-total-penjualan',
        'valueStyle' => 'color: #8027BA;',
        'label' => 'Total Penjualan',
        'sub' => 'Bulan Ini',
        'subStyle' => 'color: #8027BA; font-weight: 700;'
    ])

</div>

{{-- ============================================================
     PREVIEW DATA LAPORAN CARD & TABLE
     ============================================================ --}}
<div class="lr-table-card">
    <div class="lr-table-header">
        <h3 class="lr-table-title" id="lr-table-card-title">Preview Data Laporan (Semua Data)</h3>
        <button class="lr-btn lr-btn--secondary" style="height:32px; padding:0 12px; font-size:12px;" id="btn-view-all-data">
            Lihat Semua Data
        </button>
    </div>
    
    <div style="overflow-x:auto;">
        <table class="lr-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Produksi (Liter)</th>
                    <th>Penjualan (Rp)</th>
                    <th>Mitra / Pembeli</th>
                    <th>Catatan Kesehatan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="lr-table-body">
                {{-- Loaded via javascript --}}
            </tbody>
        </table>
    </div>

    {{-- Pagination Bar --}}
    <div class="lr-pagination-bar">
        <span class="lr-pagination-info" id="lr-pagination-info">Menampilkan 1 - 5 dari 31 Data</span>
        <nav class="lr-pagination-nav" id="lr-pagination-nav" aria-label="Navigasi halaman"></nav>
    </div>
</div>

{{-- ============================================================
     BANNER/ALERT POPUP
     ============================================================ --}}
<div class="lr-alert-banner" id="lr-success-alert">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"/>
    </svg>
    <span>Laporan Excel berhasil diunduh!</span>
</div>

@endsection

@push('scripts')
<script>
(function() {
    /* ============================================================
       Report Simulated Database (31 Data items as shown in Figma page count)
       ============================================================ */
    
    // Seed list of partners
    const partners = {!! json_encode($mitras->pluck('nama')->toArray()) !!};

    // Seed list of daily records from database
    const reportData = {!! json_encode($dates) !!};
    const rawPenjualan = {!! json_encode($penjualans) !!};
    const rawProduksi = {!! json_encode($produksis) !!};

    /* ============================================================
       State Variables
       ============================================================ */
    const defaultStartDate = "{{ Carbon\Carbon::today()->subDays(6)->format('Y-m-d') }}";
    const defaultEndDate = "{{ Carbon\Carbon::today()->format('Y-m-d') }}";
    const defaultMonthStartDate = "{{ Carbon\Carbon::today()->subDays(29)->format('Y-m-d') }}";

    let currentPage = 1;
    const PER_PAGE = 5;

    /* ============================================================
       Initialization & UI Sync
       ============================================================ */
    function init() {
        populatePartnerSelect();
        initSearchableDropdown('filter-partner', 'Cari Mitra...');
        renderTable();
        updateStats();
    }

    function populatePartnerSelect() {
        const partnerSelect = document.getElementById('filter-partner');
        partnerSelect.innerHTML = '<option value="Semua Mitra" selected>Semua Mitra</option>';
        
        partners.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p;
            opt.textContent = p;
            partnerSelect.appendChild(opt);
        });
    }

    /* ============================================================
       Helpers & Date Range Helper
       ============================================================ */
    function formatRupiah(num) {
        if (num === 0) return '—';
        return num.toLocaleString('id-ID');
    }

    const indonesianMonths = {
        'januari': 0, 'februari': 1, 'maret': 2, 'april': 3, 'mei': 4, 'juni': 5,
        'juli': 6, 'agustus': 7, 'september': 8, 'oktober': 9, 'november': 10, 'desember': 11,
        'jan': 0, 'feb': 1, 'mar': 2, 'apr': 3, 'mei': 4, 'jun': 5,
        'jul': 6, 'agu': 7, 'sep': 8, 'okt': 9, 'nov': 10, 'des': 11
    };

    function parseDateString(dateStr) {
        if (!dateStr) return new Date();
        const cleanStr = dateStr.toLowerCase().trim();
        
        // Handle ISO YYYY-MM-DD format
        if (cleanStr.match(/^\d{4}-\d{2}-\d{2}$/)) {
            const parts = cleanStr.split('-');
            return new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
        }
        
        const parts = cleanStr.split(/\s+/);
        if (parts.length === 3) {
            const day = parseInt(parts[0]);
            const monthName = parts[1];
            const year = parseInt(parts[2]);
            const month = indonesianMonths[monthName] !== undefined ? indonesianMonths[monthName] : 4; // default to May
            return new Date(year, month, day);
        }
        return new Date(dateStr);
    }

    /* ============================================================
       Filter Core Logic
       ============================================================ */
    function getFilteredData() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const reportType = document.getElementById('filter-report-type').value;
        const partner = document.getElementById('filter-partner').value;

        const startDate = startVal ? parseDateString(startVal) : null;
        const endDate = endVal ? parseDateString(endVal) : null;
        if (endDate) endDate.setHours(23, 59, 59, 999);
        if (startDate) startDate.setHours(0, 0, 0, 0);

        return reportData.filter(d => {
            // Check date range
            if (startDate || endDate) {
                const dDate = parseDateString(d.tanggal);
                if (startDate && dDate < startDate) return false;
                if (endDate && dDate > endDate) return false;
            }

            // Check Report Type
            if (reportType === 'Produksi Susu' && d.produksi === 0) return false;
            if (reportType === 'Penjualan Susu' && d.penjualan === 0) return false;

            // Check Partner
            if (partner !== 'Semua Mitra' && d.mitra !== partner) return false;

            return true;
        });
    }

    function getFilteredPenjualan() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const partner = document.getElementById('filter-partner').value;

        const startDate = startVal ? parseDateString(startVal) : null;
        const endDate = endVal ? parseDateString(endVal) : null;
        if (endDate) endDate.setHours(23, 59, 59, 999);
        if (startDate) startDate.setHours(0, 0, 0, 0);

        return rawPenjualan.filter(p => {
            if (startDate || endDate) {
                const pDate = parseDateString(p.tanggal);
                if (startDate && pDate < startDate) return false;
                if (endDate && pDate > endDate) return false;
            }
            if (partner !== 'Semua Mitra') {
                const partnerName = p.mitra ? p.mitra.nama : '';
                if (partnerName !== partner) return false;
            }
            return true;
        }).map(p => ({
            tanggal: formatIndonesianDate(p.tanggal),
            pembeli: p.mitra ? p.mitra.nama : '—',
            jumlah_terjual: parseFloat(p.jumlah_terjual) || 0,
            harga_liter: p.jumlah_terjual > 0 ? Math.round(p.total_pendapatan / p.jumlah_terjual) : 0,
            total_harga: parseFloat(p.total_pendapatan) || 0
        }));
    }

    function getFilteredProduksi() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const partner = document.getElementById('filter-partner').value;

        const startDate = startVal ? parseDateString(startVal) : null;
        const endDate = endVal ? parseDateString(endVal) : null;
        if (endDate) endDate.setHours(23, 59, 59, 999);
        if (startDate) startDate.setHours(0, 0, 0, 0);

        let allowedDates = null;
        if (partner !== 'Semua Mitra') {
            allowedDates = rawPenjualan.filter(p => p.mitra && p.mitra.nama === partner).map(p => p.tanggal);
        }

        const filteredProd = rawProduksi.filter(pr => {
            if (startDate || endDate) {
                const prDate = parseDateString(pr.tanggal);
                if (startDate && prDate < startDate) return false;
                if (endDate && prDate > endDate) return false;
            }
            if (allowedDates !== null && !allowedDates.includes(pr.tanggal)) return false;
            return true;
        });

        const groups = {};
        filteredProd.forEach(pr => {
            const code = pr.sapi ? pr.sapi.code : '—';
            const key = pr.tanggal + '_' + code;
            if (!groups[key]) {
                groups[key] = {
                    tanggal: pr.tanggal,
                    sapiCode: code,
                    pagi: 0,
                    sore: 0
                };
            }
            const vol = parseFloat(pr.jumlah_susu) || 0;
            if (pr.sesi === 'pagi') {
                groups[key].pagi += vol;
            } else if (pr.sesi === 'sore') {
                groups[key].sore += vol;
            }
        });

        return Object.values(groups).sort((a, b) => b.tanggal.localeCompare(a.tanggal)).map(g => ({
            tanggal: formatIndonesianDate(g.tanggal),
            sapiCode: g.sapiCode,
            pagi: g.pagi,
            sore: g.sore,
            total: g.pagi + g.sore
        }));
    }

    function getFilteredRekap() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const partner = document.getElementById('filter-partner').value;

        const startDate = startVal ? parseDateString(startVal) : null;
        const endDate = endVal ? parseDateString(endVal) : null;
        if (endDate) endDate.setHours(23, 59, 59, 999);
        if (startDate) startDate.setHours(0, 0, 0, 0);

        const uniqueDatesMap = {};
        
        const filteredProd = rawProduksi.filter(pr => {
            if (startDate || endDate) {
                const prDate = parseDateString(pr.tanggal);
                if (startDate && prDate < startDate) return false;
                if (endDate && prDate > endDate) return false;
            }
            return true;
        });

        const filteredPenjualan = rawPenjualan.filter(p => {
            if (startDate || endDate) {
                const pDate = parseDateString(p.tanggal);
                if (startDate && pDate < startDate) return false;
                if (endDate && pDate > endDate) return false;
            }
            if (partner !== 'Semua Mitra' && p.mitra && p.mitra.nama !== partner) return false;
            return true;
        });

        filteredProd.forEach(pr => uniqueDatesMap[pr.tanggal] = true);
        filteredPenjualan.forEach(p => uniqueDatesMap[p.tanggal] = true);

        const uniqueDates = Object.keys(uniqueDatesMap).sort((a, b) => b.localeCompare(a));

        const rekapRows = [];
        uniqueDates.forEach(tgl => {
            const dailyProd = filteredProd
                .filter(pr => pr.tanggal === tgl)
                .reduce((sum, pr) => sum + (parseFloat(pr.jumlah_susu) || 0), 0);
            
            const dailySales = filteredPenjualan.filter(p => p.tanggal === tgl);
            const dailyQtySold = dailySales.reduce((sum, p) => sum + (parseFloat(p.jumlah_terjual) || 0), 0);
            const dailyRevenue = dailySales.reduce((sum, p) => sum + (parseFloat(p.total_pendapatan) || 0), 0);
            const remaining = Math.max(0, dailyProd - dailyQtySold);

            if (dailyProd > 0 || dailyQtySold > 0) {
                rekapRows.push({
                    tanggal: formatIndonesianDate(tgl),
                    produksi: dailyProd,
                    terjual: dailyQtySold,
                    sisa: remaining,
                    pendapatan: dailyRevenue
                });
            }
        });

        return rekapRows;
    }

    /* ============================================================
       Stats Updates based on filtered list
       ============================================================ */
    function updateStats() {
        const filtered = getFilteredData();
        
        let totalProd = 0;
        let totalSale = 0;

        filtered.forEach(d => {
            totalProd += d.produksi;
            totalSale += d.penjualan;
        });

        document.getElementById('stat-produksi-susu').innerHTML = totalProd.toLocaleString('id-ID') + ' <span style="font-size: 28px; font-weight: 800; vertical-align: baseline; margin-left: 2px;">L</span>';
        document.getElementById('stat-total-penjualan').textContent = totalSale.toLocaleString('id-ID');

        // Dynamic subtext labels
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const sD = new Date(startVal);
        const eD = new Date(endVal);
        const diffTime = Math.abs(eD - sD);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        
        let rangeLabel = diffDays + ' Hari';
        if (diffDays === 7) {
            rangeLabel = '7 Hari Terakhir';
        } else if (diffDays === 30 || diffDays === 31) {
            rangeLabel = 'Bulan Ini';
        } else if (diffDays === 1) {
            rangeLabel = 'Hari Ini';
        }

        const cardProd = document.getElementById('stat-produksi-susu');
        if (cardProd) {
            const subProd = cardProd.closest('.lr-stat-card').querySelector('.lr-stat-sub');
            if (subProd) subProd.textContent = rangeLabel;
        }
        const cardSale = document.getElementById('stat-total-penjualan');
        if (cardSale) {
            const subSale = cardSale.closest('.lr-stat-card').querySelector('.lr-stat-sub');
            if (subSale) subSale.textContent = rangeLabel;
        }
    }

    /* ============================================================
       Table Render & Pagination (Exactly 5 rows preview as requested)
       ============================================================ */
    function renderTableHeader(reportType) {
        const thead = document.querySelector('.lr-table thead');
        if (!thead) return;

        let headers = [];
        if (reportType === 'Penjualan Susu') {
            headers = ['Tanggal', 'Pembeli', 'Jumlah Liter Terjual', 'Harga/Liter', 'Total Harga'];
        } else if (reportType === 'Produksi Susu') {
            headers = ['Tanggal', 'ID Sapi', 'Produksi Pagi (L)', 'Produksi Sore (L)', 'Total Produksi (L)'];
        } else {
            // Semua Data
            headers = ['Tanggal', 'Total Produksi (L)', 'Total Terjual (L)', 'Sisa Stok Susu (L)', 'Pendapatan'];
        }

        let html = '<tr>';
        headers.forEach(h => {
            html += `<th scope="col">${h}</th>`;
        });
        html += '</tr>';
        thead.innerHTML = html;
    }

    function renderTable() {
        const reportType = document.getElementById('filter-report-type').value;
        renderTableHeader(reportType);

        let data = [];
        if (reportType === 'Penjualan Susu') {
            data = getFilteredPenjualan();
        } else if (reportType === 'Produksi Susu') {
            data = getFilteredProduksi();
        } else {
            data = getFilteredRekap();
        }

        const total = data.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));

        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * PER_PAGE;
        const end = Math.min(start + PER_PAGE, total);

        const tbody = document.getElementById('lr-table-body');
        tbody.innerHTML = '';

        // Update card preview title based on filter selections
        document.getElementById('lr-table-card-title').textContent = `Preview Data Laporan (${reportType})`;

        if (total === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 40px; color:#9CA3AF;">Tidak ada data laporan ditemukan untuk kriteria filter ini.</td></tr>';
            document.getElementById('lr-pagination-info').textContent = 'Tidak ada data';
            document.getElementById('lr-pagination-nav').innerHTML = '';
            return;
        }

        const slice = data.slice(start, end);
        slice.forEach(d => {
            const tr = document.createElement('tr');
            
            if (reportType === 'Penjualan Susu') {
                tr.innerHTML = `
                    <td>${d.tanggal}</td>
                    <td>${d.pembeli}</td>
                    <td class="lr-bold">${d.jumlah_terjual.toLocaleString('id-ID')} L</td>
                    <td>Rp ${d.harga_liter.toLocaleString('id-ID')}</td>
                    <td class="lr-bold">Rp ${d.total_harga.toLocaleString('id-ID')}</td>
                `;
            } else if (reportType === 'Produksi Susu') {
                tr.innerHTML = `
                    <td>${d.tanggal}</td>
                    <td>${d.sapiCode}</td>
                    <td>${d.pagi.toLocaleString('id-ID')} L</td>
                    <td>${d.sore.toLocaleString('id-ID')} L</td>
                    <td class="lr-bold">${d.total.toLocaleString('id-ID')} L</td>
                `;
            } else {
                tr.innerHTML = `
                    <td>${d.tanggal}</td>
                    <td class="lr-bold">${d.produksi.toLocaleString('id-ID')} L</td>
                    <td class="lr-bold">${d.terjual.toLocaleString('id-ID')} L</td>
                    <td>${d.sisa.toLocaleString('id-ID')} L</td>
                    <td class="lr-bold">Rp ${d.pendapatan.toLocaleString('id-ID')}</td>
                `;
            }
            tbody.appendChild(tr);
        });

        // pagination info text
        document.getElementById('lr-pagination-info').textContent = `Menampilkan ${start + 1} - ${end} dari ${total} Data`;

        // render pagination buttons (matching < 1 2 3 ... 7 > Figma layout)
        const nav = document.getElementById('lr-pagination-nav');
        nav.innerHTML = '';

        function makePageBtn(label, page, cls, disabled) {
            const b = document.createElement('button');
            b.className = 'lr-page-btn ' + (cls || '');
            b.textContent = label;
            if (disabled) b.disabled = true;
            if (page !== null && !disabled) {
                b.addEventListener('click', () => {
                    currentPage = page;
                    renderTable();
                });
            }
            nav.appendChild(b);
        }

        // prev
        makePageBtn('\u2039', currentPage - 1, '', currentPage === 1);

        const delta = 1;
        let pages = [];
        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentPage - delta && p <= currentPage + delta)) {
                pages.push(p);
            }
        }

        let prev = null;
        pages.forEach(p => {
            if (prev !== null && p - prev > 1) {
                const el = document.createElement('button');
                el.className = 'lr-page-btn lr-page-btn--ellipsis';
                el.textContent = '...';
                el.disabled = true;
                nav.appendChild(el);
            }
            makePageBtn(p, p, p === currentPage ? 'lr-page-btn--active' : '', p === currentPage);
            prev = p;
        });

        // next
        makePageBtn('\u203A', currentPage + 1, '', currentPage === totalPages);
    }

    /* ============================================================
       Event Triggers & Action Handlers
       ============================================================ */
    // Date ranges formatting and label sync helpers
    function formatIndonesianDate(isoDateStr) {
        if (!isoDateStr) return '';
        const parts = isoDateStr.split('-');
        if (parts.length !== 3) return isoDateStr;
        const y = parseInt(parts[0]);
        const m = parseInt(parts[1]) - 1;
        const d = parseInt(parts[2]);
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        return `${d} ${months[m]} ${y}`;
    }

    function syncDateLabels() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        document.getElementById('label-start-date').textContent = startVal ? formatIndonesianDate(startVal) : 'Semua';
        document.getElementById('label-end-date').textContent = endVal ? formatIndonesianDate(endVal) : 'Semua';
    }

    // Change listeners to sync display labels
    document.getElementById('filter-start-date').addEventListener('change', syncDateLabels);
    document.getElementById('filter-end-date').addEventListener('change', syncDateLabels);

    // Make sure clicking the wrapper container or the input opens the native date picker calendar
    const startInput = document.getElementById('filter-start-date');
    const endInput = document.getElementById('filter-end-date');
    
    if (startInput) {
        startInput.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof this.showPicker === 'function') {
                try { this.showPicker(); } catch(err) {}
            }
        });
        startInput.parentElement.addEventListener('click', function(e) {
            if (e.target !== startInput) {
                startInput.focus();
                if (typeof startInput.showPicker === 'function') {
                    try { startInput.showPicker(); } catch(err) {}
                }
            }
        });
    }
    
    if (endInput) {
        endInput.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof this.showPicker === 'function') {
                try { this.showPicker(); } catch(err) {}
            }
        });
        endInput.parentElement.addEventListener('click', function(e) {
            if (e.target !== endInput) {
                endInput.focus();
                if (typeof endInput.showPicker === 'function') {
                    try { endInput.showPicker(); } catch(err) {}
                }
            }
        });
    }

    // Apply filters trigger
    document.getElementById('btn-submit-filter').addEventListener('click', function() {
        currentPage = 1;
        renderTable();
        updateStats();
    });

    // Reset filters trigger
    document.getElementById('btn-reset-filter').addEventListener('click', function() {
        document.getElementById('filter-start-date').value = '';
        document.getElementById('filter-end-date').value = '';
        document.getElementById('filter-report-type').value = "Semua Data";
        document.getElementById('filter-partner').value = "Semua Mitra";
        updateSearchableSelect('filter-partner');

        syncDateLabels();
        currentPage = 1;
        renderTable();
        updateStats();
    });

    // Export Excel action trigger
    document.getElementById('btn-export-excel').addEventListener('click', function() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const reportType = document.getElementById('filter-report-type').value;
        const partner = document.getElementById('filter-partner').value;

        // Redirect to backend Excel download route with query filters
        const url = "{{ route('owner.laporan.export') }}" + 
            "?start_date=" + encodeURIComponent(startVal) + 
            "&end_date=" + encodeURIComponent(endVal) + 
            "&report_type=" + encodeURIComponent(reportType) + 
            "&partner=" + encodeURIComponent(partner);
            
        window.location.href = url;

        // Show download alert banner
        const alertBanner = document.getElementById('lr-success-alert');
        if (alertBanner) {
            alertBanner.querySelector('span').textContent = 'Laporan Excel berhasil diunduh!';
            alertBanner.style.display = 'inline-flex';
            setTimeout(() => {
                alertBanner.style.display = 'none';
            }, 3000);
        }
    });

    // View all data button trigger
    document.getElementById('btn-view-all-data').addEventListener('click', function() {
        document.getElementById('filter-start-date').value = defaultMonthStartDate;
        document.getElementById('filter-end-date').value = defaultEndDate;
        document.getElementById('filter-report-type').value = "Semua Data";
        document.getElementById('filter-partner').value = "Semua Mitra";
        updateSearchableSelect('filter-partner');

        syncDateLabels();
        currentPage = 1;
        renderTable();
        updateStats();
    });

    function updateSearchableSelect(selectId) {
        const select = document.getElementById(selectId);
        if (select && select.nextElementSibling && select.nextElementSibling.classList.contains('hybrid-select-wrapper')) {
            const display = select.nextElementSibling.querySelector('.hybrid-select-display');
            const selectedOpt = select.options[select.selectedIndex];
            display.textContent = selectedOpt ? selectedOpt.textContent : 'Pilih...';
        }
    }

    function initSearchableDropdown(selectId, placeholder = 'Cari...') {
        const originalSelect = document.getElementById(selectId);
        if (!originalSelect) return;

        // Hide original select
        originalSelect.style.display = 'none';
        
        const wrapper = document.createElement('div');
        wrapper.className = 'hybrid-select-wrapper';
        
        const display = document.createElement('div');
        display.className = 'hybrid-select-display';
        const selectedOpt = originalSelect.options[originalSelect.selectedIndex];
        display.textContent = selectedOpt ? selectedOpt.textContent : 'Pilih Mitra';
        
        const dropdown = document.createElement('div');
        dropdown.className = 'hybrid-select-dropdown';
        
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'hybrid-select-search';
        searchInput.placeholder = placeholder;
        
        const optionsList = document.createElement('div');
        optionsList.className = 'hybrid-select-options';
        
        const noResults = document.createElement('div');
        noResults.className = 'hybrid-select-no-results';
        noResults.textContent = 'Tidak ada hasil';
        noResults.style.display = 'none';
        
        function repopulate() {
            optionsList.innerHTML = '';
            Array.from(originalSelect.options).forEach(opt => {
                if (opt.value === '' && opt.disabled) return;
                const item = document.createElement('div');
                item.className = 'hybrid-select-option';
                if (opt.value == originalSelect.value) {
                    item.classList.add('hybrid-select-option--selected');
                }
                item.dataset.value = opt.value;
                item.textContent = opt.textContent;
                optionsList.appendChild(item);
            });
        }
        repopulate();
        
        dropdown.appendChild(searchInput);
        dropdown.appendChild(optionsList);
        dropdown.appendChild(noResults);
        
        wrapper.appendChild(display);
        wrapper.appendChild(dropdown);
        
        originalSelect.parentNode.insertBefore(wrapper, originalSelect.nextSibling);

        display.addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelectorAll('.hybrid-select-dropdown').forEach(el => {
                if (el !== dropdown) el.style.display = 'none';
            });
            const isOpen = dropdown.style.display === 'block';
            dropdown.style.display = isOpen ? 'none' : 'block';
            if (!isOpen) {
                searchInput.value = '';
                filterOptions('');
                searchInput.focus();
                repopulate();
            }
        });

        searchInput.addEventListener('click', e => e.stopPropagation());
        searchInput.addEventListener('input', function() {
            filterOptions(this.value);
        });

        function filterOptions(query) {
            const cleanQuery = query.toLowerCase().trim();
            const items = optionsList.querySelectorAll('.hybrid-select-option');
            let visibleCount = 0;
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(cleanQuery)) {
                    item.classList.remove('hybrid-select-option--hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hybrid-select-option--hidden');
                }
            });
            
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        optionsList.addEventListener('click', function(e) {
            const item = e.target.closest('.hybrid-select-option');
            if (!item) return;
            
            originalSelect.value = item.dataset.value;
            originalSelect.dispatchEvent(new Event('change'));
            
            display.textContent = item.textContent;
            dropdown.style.display = 'none';
        });

        document.addEventListener('click', function() {
            dropdown.style.display = 'none';
        });
    }

    // Run init
    init();
    syncDateLabels();

})();
</script>
@endpush
