@extends('layouts.owner')

@section('title', 'Penjualan Susu')
@section('page-title', 'Penjualan Susu')
@section('page-subtitle', 'Kelola penjualan susu ke mitra')

@push('styles')
<style>
/* ============================================================
   Penjualan Susu | Owner Page CSS — Figma Node 142-3 & 237-113
   ============================================================ */

/* ── Top Header Title & Action Buttons ──────────────────────── */
.pj-header-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 16px;
    flex-wrap: wrap;
}
.pj-header-title {
    display: flex;
    flex-direction: column;
}
.pj-header-title h2 {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 4px 0;
}
.pj-header-title p {
    font-size: 13.5px;
    font-weight: 500;
    color: #6B7280;
    margin: 0;
}
.pj-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

.pj-btn {
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
.pj-btn--primary {
    background: #124827;
    color: #FFFFFF;
}
.pj-btn--primary:hover {
    background: #0e3a1f;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(18, 72, 39, 0.2);
}
.pj-btn--secondary {
    background: #FFFFFF;
    border: 1.5px solid #D1D5DB;
    color: #374151;
}
.pj-btn--secondary:hover {
    background: #F9FAFB;
    border-color: #9CA3AF;
}
.pj-btn img {
    width: 16px;
    height: 16px;
}

/* ── Filters Section ───────────────────────────────────────── */
.pj-filters-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.pj-filter-date-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    padding: 0 20px;
    height: 54px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.pj-filter-date-group {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #F9FAFB;
    border: 1.5px solid #E5E7EB;
    padding: 0 14px;
    border-radius: 10px;
    height: 42px;
}
.pj-filter-date-group input {
    border: none;
    background: transparent;
    font-size: 13.5px;
    font-weight: 700;
    color: #374151;
    font-family: 'Manrope', sans-serif;
    outline: none;
    width: 125px;
    cursor: pointer;
}
.pj-filter-date-group img {
    width: 16px;
    height: 16px;
    opacity: 0.6;
}
.pj-filter-sep {
    font-size: 13.5px;
    font-weight: 700;
    color: #9CA3AF;
}
.pj-filter-select {
    height: 54px;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    padding: 0 38px 0 16px;
    font-size: 13.5px;
    font-weight: 700;
    color: #374151;
    font-family: 'Manrope', sans-serif;
    background: #FFFFFF url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 14px center;
    -webkit-appearance: none;
    appearance: none;
    outline: none;
    cursor: pointer;
    min-width: 190px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.pj-filter-btn {
    height: 54px;
    background: #FFFFFF;
    border: 1px solid #D1D5DB;
    color: #374151;
    border-radius: 14px;
    padding: 0 20px;
    font-size: 13.5px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: pointer;
    transition: all 0.15s;
}
.pj-filter-btn img {
    width: 12px !important;
    height: 12px !important;
}
.pj-filter-btn:hover {
    background: #F9FAFB;
    border-color: #9CA3AF;
}

/* ── Stat Cards ────────────────────────────────── */
.pj-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}
.pj-stat-card {
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
.pj-stat-card:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.09);
    transform: translateY(-2px);
}
.pj-stat-icon-wrap {
    grid-area: icon;
    width: 56px !important;
    height: 56px !important;
    object-fit: contain;
    justify-self: start;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent !important;
    border-radius: 0;
}
.pj-stat-icon-wrap img {
    width: 56px !important;
    height: 56px !important;
}

.pj-stat-content {
    display: contents !important;
}
.pj-stat-value {
    grid-area: value;
    font-size: 38px !important;
    font-weight: 800;
    line-height: 1;
    margin: 0;
    align-self: center;
    justify-self: start;
    text-align: left;
}
.pj-stat-card--green .pj-stat-value { color: #068B4A; }

.pj-stat-label {
    grid-area: label;
    font-size: 13.5px !important;
    font-weight: 700;
    color: #4B5563;
    margin: 4px 0 0 0 !important;
    line-height: 1.3;
}
.pj-stat-sub {
    grid-area: sub;
    font-size: 13px !important;
    font-weight: 700;
    margin: 2px 0 0 0 !important;
    line-height: 1.3;
    display: flex;
    align-items: center;
    gap: 4px;
}
.pj-stat-sub--up { color: #16A34A; }
.pj-stat-sub--down { color: #DC2626; }
.pj-stat-sub--neutral { color: #6B7280; font-weight: 500; }

/* Combined Stat Card Styles */
.pj-stat-card--combined {
    grid-column: span 2;
    display: flex !important;
    padding: 0 !important;
    align-items: stretch;
    gap: 0;
}
.pj-stat-combined-section {
    flex: 1;
    padding: 24px 20px;
    display: grid !important;
    grid-template-columns: auto 1fr;
    grid-template-rows: auto auto auto;
    align-items: center;
    gap: 4px 16px;
    box-sizing: border-box;
}
.pj-stat-combined-section--left {
    grid-template-areas: 
        "icon value"
        ". label"
        ". sub";
}
.pj-stat-combined-section--right {
    grid-template-areas: 
        "icon value"
        ". label";
    grid-template-rows: auto auto;
}
.pj-stat-divider {
    width: 1.5px;
    background-color: #E2E8F0;
    margin: 24px 0;
    flex-shrink: 0;
}

@media (max-width: 1200px) {
    .pj-stats {
        grid-template-columns: 1fr 1fr;
    }
    .pj-stat-card--combined {
        grid-column: span 2;
    }
}
@media (max-width: 768px) {
    .pj-stats {
        grid-template-columns: 1fr;
    }
    .pj-stat-card--combined {
        grid-column: span 1;
        flex-direction: column;
        align-items: flex-start;
    }
    .pj-stat-divider {
        width: 100%;
        height: 1.5px;
        margin: 0;
    }
    .pj-stat-combined-section {
        width: 100%;
    }
}

/* ── Main Data Table Card ─────────────────────────────────── */
.pj-table-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}
.pj-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Manrope', sans-serif;
}
.pj-table thead th {
    padding: 16px 20px;
    font-size: 14px;
    font-weight: 800;
    color: #111827;
    text-align: left;
    background: #FAFAFA;
    border-bottom: 1.5px solid #E5E7EB;
    white-space: nowrap;
}
.pj-table thead th:nth-child(3),
.pj-table tbody td:nth-child(3),
.pj-table thead th:nth-child(4),
.pj-table tbody td:nth-child(4),
.pj-table thead th:nth-child(5),
.pj-table tbody td:nth-child(5),
.pj-table thead th:nth-child(7),
.pj-table tbody td:nth-child(7) {
    text-align: center;
}
.pj-table tbody tr {
    border-bottom: 1px solid #F3F4F6;
    transition: background 0.1s;
}
.pj-table tbody tr:last-child { border-bottom: none; }
.pj-table tbody tr:hover { background: #F9FAFB; }

.pj-table tbody td {
    padding: 16px 20px;
    font-size: 13.5px;
    color: #111827;
    vertical-align: middle;
}
.pj-table tbody td.pj-bold {
    font-weight: 700;
}

/* Status Badges */
.pj-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 24px;
    padding: 0 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
}
.pj-badge--selesai {
    background: #DEF7EC;
    color: #03543F;
}
.pj-badge--pending {
    background: #FEF3C7;
    color: #92400E;
}
.pj-badge--dibatalkan {
    background: #FDE8E8;
    color: #9B1C1C;
}

/* Pagination Bar */
.pj-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-top: 1px solid #E5E7EB;
    gap: 12px;
}
.pj-pagination-info {
    font-size: 12.5px;
    font-weight: 600;
    color: #6B7280;
}
.pj-pagination-nav {
    display: flex;
    align-items: center;
    gap: 4px;
}

/* ── Modal Overlay & Card Styles (Figma Exact Modal Mockups) ─ */
.pj-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(2px);
    z-index: 1000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.pj-modal-overlay--open {
    display: flex;
}
.pj-modal {
    background: #FFFFFF;
    border-radius: 16px;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    width: 100%;
    max-width: 520px;
    overflow: hidden;
    position: relative;
    border: 1px solid #E2E8F0;
    animation: pjModalFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes pjModalFadeIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}

.pj-modal__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    border-bottom: 1px solid #F3F4F6;
}
.pj-modal__title {
    font-size: 16px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}
.pj-modal__close {
    background: none;
    border: none;
    cursor: pointer;
    color: #9CA3AF;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.15s;
    padding: 4px;
}
.pj-modal__close:hover { color: #374151; }

.pj-modal__body {
    padding: 20px 24px;
    max-height: 70vh;
    overflow-y: auto;
}

/* Modal Form Layout */
.pj-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.pj-form-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.pj-form-field--full {
    grid-column: span 2;
}
.pj-form-label {
    font-size: 12.5px;
    font-weight: 700;
    color: #374151;
}

.pj-form-input {
    height: 40px;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    padding: 0 12px;
    font-size: 13.5px;
    font-weight: 600;
    color: #111827;
    font-family: 'Manrope', sans-serif;
    outline: none;
    background: #FFFFFF;
    transition: border-color 0.15s;
}
.pj-form-input:focus { border-color: #124827; }
.pj-form-input::placeholder { color: #9CA3AF; font-weight: 400; }
.pj-form-input[readonly] {
    background: #F3F4F6;
    color: #6B7280;
    cursor: not-allowed;
}

.pj-form-select {
    height: 40px;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    padding: 0 34px 0 12px;
    font-size: 13.5px;
    font-weight: 600;
    color: #111827;
    font-family: 'Manrope', sans-serif;
    outline: none;
    background: #FFFFFF url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
    -webkit-appearance: none;
    appearance: none;
    cursor: pointer;
    transition: border-color 0.15s;
}
.pj-form-select:focus { border-color: #124827; }

.pj-form-textarea {
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 13.5px;
    font-weight: 600;
    color: #111827;
    font-family: 'Manrope', sans-serif;
    outline: none;
    resize: vertical;
    min-height: 80px;
    transition: border-color 0.15s;
}
.pj-form-textarea:focus { border-color: #124827; }
.pj-form-textarea::placeholder { color: #9CA3AF; font-weight: 400; }

.pj-form-row-btn {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pj-form-row-btn select {
    flex: 1;
}

.pj-modal__footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid #F3F4F6;
    background: #FAFAFA;
}

/* Modal Kelola Mitra (wider modal size) */
.pj-modal--large {
    max-width: 680px;
}

/* Table in Kelola Mitra */
.pj-mitra-table-wrap {
    margin-top: 14px;
    border: 1px solid #E5E7EB;
    border-radius: 10px;
    overflow: hidden;
}
.pj-mitra-table {
    width: 100%;
    border-collapse: collapse;
}
.pj-mitra-table th {
    padding: 10px 14px;
    font-size: 12px;
    font-weight: 700;
    color: #4B5563;
    background: #F9FAFB;
    border-bottom: 1px solid #E5E7EB;
    text-align: left;
}
.pj-mitra-table td {
    padding: 10px 14px;
    font-size: 13px;
    color: #111827;
    border-bottom: 1px solid #F3F4F6;
}
.pj-mitra-table tr:last-child td { border-bottom: none; }

.pj-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: 1.5px solid #E5E7EB;
    background: #FFFFFF;
    cursor: pointer;
    color: #4B5563;
    transition: all 0.15s;
    padding: 0;
}
.pj-action-btn--edit:hover {
    border-color: #124827;
    color: #124827;
    background: #F0FDF4;
}
.pj-action-btn--delete:hover {
    border-color: #DC2626;
    color: #DC2626;
    background: #FEF2F2;
}
.pj-action-btn img {
    width: 13px;
    height: 13px;
}

/* Validation error text */
.pj-validation-err {
    font-size: 11.5px;
    color: #DC2626;
    font-weight: 700;
    margin-top: 3px;
    display: none;
}
.pj-field--error input,
.pj-field--error select,
.pj-field--error textarea {
    border-color: #DC2626 !important;
}
.pj-field--error .pj-validation-err {
    display: block;
}

/* Responsive elements */
@media (max-width: 1200px) {
    .pj-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .pj-stats { grid-template-columns: 1fr; }
    .pj-form-grid { grid-template-columns: 1fr; }
    .pj-form-field--full { grid-column: span 1; }
}

</style>
@endpush

@section('topbar-right')
<div style="display: flex; align-items: center; gap: 12px;">
    <button type="button" class="pj-btn" id="btn-open-tambah-penjualan" style="background: #124827; border: none; color: #FFFFFF; border-radius: 8px; height: 42px; padding: 0 20px; font-weight: 700; font-family: 'Manrope', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
        <img src="{{ asset('images/icons/iconplus.svg') }}" style="width: 14px; height: 14px;" alt="">
        Tambah Penjualan
    </button>
    <button type="button" class="pj-btn" id="btn-open-kelola-mitra" style="background: #FFFFFF; border: 1.5px solid #D1D5DB; color: #374151; border-radius: 8px; height: 42px; padding: 0 20px; font-weight: 700; font-family: 'Manrope', sans-serif; cursor: pointer; display: inline-flex; align-items: center;">
        Kelola Mitra
    </button>
</div>
@endsection

@section('content')

{{-- ============================================================
     FILTERS ROW (Split into separate cards)
     ============================================================ --}}
<div class="pj-filters-row" style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
    <!-- Start Date Input Wrapper -->
    <div class="pj-filter-date-wrapper" style="position: relative; display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 0 16px; height: 52px; width: 210px; box-sizing: border-box; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <span id="display-start-date" style="font-size: 15.5px; font-weight: 700; color: #111827;">{{ Carbon\Carbon::today()->subDays(6)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
        <img src="{{ asset('images/icons/icon kalender.svg') }}" style="width: 20px; height: 20px; pointer-events: none;" alt="">
        <input type="date" id="filter-start-date" value="{{ Carbon\Carbon::today()->subDays(6)->format('Y-m-d') }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;">
    </div>

    <!-- Separator -->
    <span class="pj-filter-sep" style="font-size: 15.5px; font-weight: 700; color: #6B7280; margin: 0 4px;">s/d</span>

    <!-- End Date Input Wrapper -->
    <div class="pj-filter-date-wrapper" style="position: relative; display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 0 16px; height: 52px; width: 210px; box-sizing: border-box; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <span id="display-end-date" style="font-size: 15.5px; font-weight: 700; color: #111827;">{{ Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
        <img src="{{ asset('images/icons/icon kalender.svg') }}" style="width: 20px; height: 20px; pointer-events: none;" alt="">
        <input type="date" id="filter-end-date" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;">
    </div>

    <!-- Semua Pembeli Select -->
    <div style="position: relative; display: flex; align-items: center;">
        <select class="pj-filter-select" id="filter-buyer" style="background: #FFFFFF; border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 0 44px 0 18px; height: 52px; font-size: 15.5px; font-weight: 700; color: #111827; font-family: 'Manrope', sans-serif; appearance: none; -webkit-appearance: none; cursor: pointer; min-width: 240px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); outline: none;">
            <option value="">Semua Pembeli</option>
        </select>
        <span style="position: absolute; right: 18px; font-size: 15px; font-weight: 800; color: #111827; pointer-events: none; line-height: 1;">∨</span>
    </div>

    <!-- Filter Button -->
    <button class="pj-filter-btn" id="btn-apply-filters" style="background: #FFFFFF; border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 0 24px; height: 52px; font-size: 15.5px; font-weight: 700; color: #124827; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); cursor: pointer; transition: all 0.15s; outline: none;">
        <img src="{{ asset('images/icons/iconfilter.svg') }}" style="width: 16px; height: 16px; filter: brightness(0) saturate(100%) invert(20%) sepia(85%) saturate(415%) hue-rotate(94deg) brightness(91%) contrast(93%);" alt="">
        Filter
    </button>
    <button class="pj-filter-btn" id="btn-reset-filters" style="background: #FFFFFF; border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 0 24px; height: 52px; font-size: 15.5px; font-weight: 700; color: #DC2626; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); cursor: pointer; transition: all 0.15s; outline: none;">
        Reset
    </button>
</div>

{{-- ============================================================
     STAT CARDS (Green, Volume, Transaksi)
     ============================================================ --}}
<div class="pj-stats">

    {{-- Total Penjualan --}}
    <div class="pj-stat-card pj-stat-card--green">
        <div class="pj-stat-icon-wrap">
            <img src="{{ asset('images/icons/iconkeranjang.svg') }}" alt="Total Penjualan">
        </div>
        <div class="pj-stat-content">
            <div class="pj-stat-value" id="stat-total-penjualan">Rp 0</div>
            <span class="pj-stat-label">Total Penjualan</span>
            <span class="pj-stat-sub pj-stat-sub--neutral" id="stat-total-penjualan-growth">▲ 0% dari bulan lalu</span>
        </div>
    </div>

    {{-- Penjualan Bersih --}}
    <div class="pj-stat-card pj-stat-card--green">
        <div class="pj-stat-icon-wrap">
            <img src="{{ asset('images/icons/iconuang.svg') }}" alt="Penjualan Bersih">
        </div>
        <div class="pj-stat-content">
            <div class="pj-stat-value" id="stat-penjualan-bersih">Rp 0</div>
            <span class="pj-stat-label">Penjualan Bersih</span>
            <span class="pj-stat-sub pj-stat-sub--neutral" id="stat-penjualan-bersih-growth">▲ 0% dari bulan lalu</span>
        </div>
    </div>

    {{-- Combined Volume & Transaksi --}}
    <div class="pj-stat-card pj-stat-card--combined">
        <div class="pj-stat-combined-section pj-stat-combined-section--left">
            <div class="pj-stat-icon-wrap">
                <img src="{{ asset('images/icons/iconbotolsusubiru.svg') }}" alt="Total Volume">
            </div>
            <div class="pj-stat-content">
                <div class="pj-stat-value" id="stat-total-volume" style="color: #000000;">0 <span style="color: #068B4A; font-weight: 700; margin-left: 4px;">Liter</span></div>
                <span class="pj-stat-label">Total Volume</span>
                <span class="pj-stat-sub pj-stat-sub--neutral" id="stat-total-volume-growth">▲ 0% dari bulan lalu</span>
            </div>
        </div>
        
        <div class="pj-stat-divider"></div>
        
        <div class="pj-stat-combined-section pj-stat-combined-section--right">
            <div class="pj-stat-icon-wrap">
                <img src="{{ asset('images/icons/iconorang.svg') }}" alt="Total Transaksi">
            </div>
            <div class="pj-stat-content">
                <div class="pj-stat-value" id="stat-total-transaksi" style="color: #000000;">0</div>
                <span class="pj-stat-label">Total Transaksi</span>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================
     MAIN DATA TABLE
     ============================================================ --}}
<div class="pj-table-card">
    <div class="pj-table-wrap">
        <table class="pj-table" id="pj-main-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Volume (Liter)</th>
                    <th>Harga / Liter</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="pj-table-body">
                {{-- Loaded via javascript --}}
            </tbody>
        </table>
    </div>

    {{-- Pagination Bar --}}
    <div class="pj-pagination-bar">
        <span class="pj-pagination-info" id="pj-main-pagination-info">Menampilkan 1 - 5 dari 8 Data</span>
        <nav class="pj-pagination-nav" id="pj-main-pagination-nav" aria-label="Navigasi halaman"></nav>
    </div>
</div>


{{-- ============================================================
     MODAL 1: TAMBAH PENJUALAN SUSU
     ============================================================ --}}
<div class="pj-modal-overlay" id="modal-tambah-penjualan">
    <div class="pj-modal" style="background: #FFFFFF; border-radius: 12px; max-width: 440px; padding: 24px; width: 100%; box-sizing: border-box; font-family: 'Manrope', sans-serif;">
        <div class="pj-modal__header" style="padding: 0 0 16px 0; border-bottom: none; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <h3 class="pj-modal__title" style="font-size: 16.5px; font-weight: 800; color: #000000; margin: 0;">Tambah Penjualan Susu</h3>
            <button type="button" class="pj-modal__close" onclick="closeModal('modal-tambah-penjualan')" style="font-size: 20px; font-weight: 900; color: #000000; border: none; background: none; cursor: pointer; padding: 0; line-height: 1;">X</button>
        </div>
        <form id="form-tambah-penjualan" novalidate>
            <input type="hidden" id="input-pj-status" value="Selesai">
            
            <!-- Tanggal -->
            <div class="pj-form-field pj-form-field--full" id="field-penjualan-tanggal" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Tanggal</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="date" class="pj-form-input" id="input-pj-tanggal" style="padding: 10px 42px 10px 14px; width: 100%; box-sizing: border-box; font-weight: 700; height: 42px; background: #FFFFFF; border: 1.5px solid #E5E7EB; border-radius: 8px; appearance: none; -webkit-appearance: none; font-family: 'Manrope', sans-serif;">
                    <img src="{{ asset('images/icons/icon kalender.svg') }}" style="position: absolute; right: 14px; width: 18px; height: 18px; pointer-events: none;" alt="">
                </div>
                <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">Tanggal wajib diisi.</span>
            </div>

            <!-- Mitra / Pembeli -->
            <div class="pj-form-field pj-form-field--full" id="field-penjualan-mitra" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Mitra / Pembeli</label>
                <div style="display: flex; gap: 12px; align-items: center; width: 100%;">
                    <div style="position: relative; flex: 1; display: flex; align-items: center;">
                        <select class="pj-form-select" id="input-pj-mitra" style="width: 100%; padding-right: 40px; font-weight: 700; border: 1.5px solid #E5E7EB; border-radius: 8px; height: 42px; appearance: none; -webkit-appearance: none; background: #FFFFFF;">
                            <option value="" disabled selected>Pilih Mitra</option>
                        </select>
                        <span style="position: absolute; right: 14px; font-size: 14px; font-weight: 800; color: #111827; pointer-events: none; line-height: 1;">∨</span>
                    </div>
                    <button type="button" class="pj-btn" id="btn-open-tambah-mitra-from-sales" style="background: #FFFFFF; border: 1.5px solid #124827; color: #124827; border-radius: 8px; height: 42px; padding: 0 16px; font-weight: 700; white-space: nowrap; font-size: 13px; cursor: pointer;">
                        + Tambah Mitra Baru
                    </button>
                </div>
                <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">Mitra wajib dipilih.</span>
            </div>

            <!-- Volume & Harga Side by Side -->
            <div style="display: flex; gap: 16px; margin-bottom: 12px;">
                <div style="flex: 1;" id="field-penjualan-volume">
                    <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Volume (Liter)</label>
                    <input type="number" class="pj-form-input" id="input-pj-volume" placeholder="150" style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 700; box-sizing: border-box; height: 42px;">
                    <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">Volume wajib diisi.</span>
                </div>
                <div style="flex: 1;" id="field-penjualan-harga">
                    <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Harga / Liter (Rp)</label>
                    <input type="number" class="pj-form-input" id="input-pj-harga" placeholder="16500" style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 700; box-sizing: border-box; height: 42px;">
                    <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">Harga wajib diisi.</span>
                </div>
            </div>

            <!-- Total -->
            <div class="pj-form-field pj-form-field--full" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Total</label>
                <input type="text" class="pj-form-input" id="input-pj-total" value="Rp 0" readonly style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 700; box-sizing: border-box; height: 42px; background: #F3F4F6; color: #4B5563;">
            </div>

            <!-- Metode Pembayaran -->
            <div class="pj-form-field pj-form-field--full" id="field-penjualan-metode" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Metode Pembayaran</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <select class="pj-form-select" id="input-pj-metode" style="width: 100%; padding-right: 40px; font-weight: 700; border: 1.5px solid #E5E7EB; border-radius: 8px; height: 42px; appearance: none; -webkit-appearance: none; background: #FFFFFF;">
                        <option value="Transfer Bank" selected>Transfer Bank</option>
                        <option value="Tunai">Tunai</option>
                    </select>
                    <span style="position: absolute; right: 14px; font-size: 14px; font-weight: 800; color: #111827; pointer-events: none; line-height: 1;">∨</span>
                </div>
                <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">Metode wajib dipilih.</span>
            </div>

            <!-- Catatan (Opsional) -->
            <div class="pj-form-field pj-form-field--full" style="margin-bottom: 20px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Catatan (Opsional)</label>
                <textarea class="pj-form-textarea" id="input-pj-catatan" placeholder="Contoh: Penjualan rutin harian" style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 600; box-sizing: border-box; min-height: 70px; resize: vertical;"></textarea>
            </div>

            <!-- Form Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="pj-btn" onclick="closeModal('modal-tambah-penjualan')" style="background: #FFFFFF; border: 1.5px solid #D1D5DB; color: #374151; border-radius: 8px; height: 42px; padding: 0 24px; font-weight: 700; cursor: pointer;">Batal</button>
                <button type="submit" class="pj-btn" id="btn-save-penjualan" style="background: #124827; border: none; color: #FFFFFF; border-radius: 8px; height: 42px; padding: 0 24px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                    <span style="font-size: 16px;">✓</span> Simpan
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ============================================================
     MODAL 2: KELOLA MITRA / PEMBELI
     ============================================================ --}}
<div class="pj-modal-overlay" id="modal-kelola-mitra">
    <div class="pj-modal pj-modal--large">
        <div class="pj-modal__header">
            <h3 class="pj-modal__title">Kelola Mitra / Pembeli</h3>
            <button class="pj-modal__close" onclick="closeModal('modal-kelola-mitra')" aria-label="Tutup">&times;</button>
        </div>
        <div class="pj-modal__body">
            <div style="display: flex; gap: 10px; margin-bottom: 14px;">
                <input type="text" class="pj-form-input" style="flex:1;" id="search-mitra-input" placeholder="Cari mitra...">
                <button class="pj-btn pj-btn--primary" style="height: 40px;" id="btn-open-tambah-mitra-from-list">
                    + Tambah Mitra
                </button>
            </div>

            <div class="pj-mitra-table-wrap">
                <table class="pj-mitra-table">
                    <thead>
                        <tr>
                            <th>Nama Mitra</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pj-mitra-table-body">
                        {{-- Loaded via javascript --}}
                    </tbody>
                </table>
            </div>

            <div class="pj-pagination-bar" style="border-top:none; padding: 12px 0 0 0;">
                <span class="pj-pagination-info" id="pj-mitra-pagination-info">Menampilkan 1 - 5 dari 12 data</span>
                <nav class="pj-pagination-nav" id="pj-mitra-pagination-nav"></nav>
            </div>
        </div>
    </div>
</div>


{{-- ============================================================
     MODAL 3: TAMBAH / EDIT MITRA
     ============================================================ --}}
<div class="pj-modal-overlay" id="modal-tambah-mitra" style="z-index: 1010;">
    <div class="pj-modal" style="background: #FFFFFF; border-radius: 12px; max-width: 380px; padding: 24px; width: 100%; box-sizing: border-box; font-family: 'Manrope', sans-serif;">
        <div class="pj-modal__header" style="padding: 0 0 16px 0; border-bottom: none; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <h3 class="pj-modal__title" id="modal-mitra-title" style="font-size: 16.5px; font-weight: 800; color: #000000; margin: 0;">Tambah Mitra / Pembeli</h3>
            <button type="button" class="pj-modal__close" onclick="closeModal('modal-tambah-mitra')" style="font-size: 20px; font-weight: 900; color: #000000; border: none; background: none; cursor: pointer; padding: 0; line-height: 1;">X</button>
        </div>
        <form id="form-tambah-mitra" novalidate>
            <input type="hidden" id="edit-mitra-index" value="">
            <input type="hidden" id="edit-mitra-id" value="">
            
            <!-- Nama Mitra -->
            <div class="pj-form-field pj-form-field--full" id="field-mitra-nama" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Nama Mitra</label>
                <input type="text" class="pj-form-input" id="input-mitra-nama" placeholder="Contoh: UD. Maju Jaya" style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 600; box-sizing: border-box; height: 42px;">
                <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">Nama mitra wajib diisi.</span>
            </div>

            <!-- No. Telepon / WhatsApp -->
            <div class="pj-form-field pj-form-field--full" id="field-mitra-kontak" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">No. Telepon / WhatsApp</label>
                <input type="text" class="pj-form-input" id="input-mitra-kontak" placeholder="08xxxxxxxxxx" style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 600; box-sizing: border-box; height: 42px;">
                <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">No. Telepon wajib diisi.</span>
            </div>

            <!-- Alamat -->
            <div class="pj-form-field pj-form-field--full" id="field-mitra-alamat" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Alamat</label>
                <textarea class="pj-form-textarea" id="input-mitra-alamat" placeholder="Contoh: Jl. Raya Solo Km. 12" style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 600; box-sizing: border-box; min-height: 70px; resize: vertical;"></textarea>
                <span class="pj-validation-err" style="color: #EF4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none;">Alamat wajib diisi.</span>
            </div>

            <!-- Catatan (Opsional) -->
            <div class="pj-form-field pj-form-field--full" style="margin-bottom: 20px;">
                <label style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Catatan (Opsional)</label>
                <textarea class="pj-form-textarea" id="input-mitra-catatan" placeholder="Contoh: Mitra tetap" style="width: 100%; border: 1.5px solid #E5E7EB; border-radius: 8px; padding: 10px 14px; font-weight: 600; box-sizing: border-box; min-height: 70px; resize: vertical;"></textarea>
            </div>

            <!-- Form Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="pj-btn" onclick="closeModal('modal-tambah-mitra')" style="background: #FFFFFF; border: 1.5px solid #D1D5DB; color: #374151; border-radius: 8px; height: 42px; padding: 0 24px; font-weight: 700; cursor: pointer;">Batal</button>
                <button type="submit" class="pj-btn" style="background: #124827; border: none; color: #FFFFFF; border-radius: 8px; height: 42px; padding: 0 24px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                    <span style="font-size: 16px;">✓</span> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
    /* ============================================================
       State & LocalStorage Management
       ============================================================ */
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Initial Seed Data for Mitras
    const defaultMitras = {!! json_encode($mitras) !!};

    // Initial Seed Data for Sales/Penjualan
    const defaultSales = {!! json_encode($sales) !!};

    // Synchronize localStorage with Laravel database data on page load
    localStorage.setItem('pj_mitras', JSON.stringify(defaultMitras));
    localStorage.setItem('pj_sales', JSON.stringify(defaultSales));

    let mitras = JSON.parse(localStorage.getItem('pj_mitras'));
    let sales = JSON.parse(localStorage.getItem('pj_sales'));

    function saveState() {
        localStorage.setItem('pj_mitras', JSON.stringify(mitras));
        localStorage.setItem('pj_sales', JSON.stringify(sales));
        populateMitraDropdowns();
        renderMainTable();
        renderMitraTable();
        updateStats();
    }

    /* ============================================================
       Helpers & Formatting
       ============================================================ */
    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function parseRupiah(str) {
        return parseInt(str.replace(/[^0-9]/g, '')) || 0;
    }

    // Custom date parser for range filtering (handles "DD MMMM YYYY" in Indonesian)
    const indonesianMonths = {
        'januari': 0, 'februari': 1, 'maret': 2, 'april': 3, 'mei': 4, 'juni': 5,
        'juli': 6, 'agustus': 7, 'september': 8, 'oktober': 9, 'november': 10, 'desember': 11,
        'jan': 0, 'feb': 1, 'mar': 2, 'apr': 3, 'mei': 4, 'jun': 5,
        'jul': 6, 'agu': 7, 'sep': 8, 'okt': 9, 'nov': 10, 'des': 11
    };

    function parseDateString(dateStr) {
        if (!dateStr) return new Date();
        const cleanStr = dateStr.toLowerCase().trim();
        
        // Handle ISO YYYY-MM-DD format safely
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
       Open/Close Modals
       ============================================================ */
    window.openModal = function(id) {
        document.getElementById(id).classList.add('pj-modal-overlay--open');
    }

    window.closeModal = function(id) {
        document.getElementById(id).classList.remove('pj-modal-overlay--open');
        clearFormErrors(id);
    }

    function clearFormErrors(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.querySelectorAll('.pj-field--error').forEach(el => el.classList.remove('pj-field--error'));
        }
    }

    /* ============================================================
       Dropdowns Population
       ============================================================ */
    function populateMitraDropdowns() {
        const pjMitraSelect = document.getElementById('input-pj-mitra');
        const filterBuyerSelect = document.getElementById('filter-buyer');

        const currentSelectedBuyer = filterBuyerSelect.value;
        const currentSelectedPjMitra = pjMitraSelect.value;

        // Reset
        pjMitraSelect.innerHTML = '<option value="" disabled selected>Pilih Mitra</option>';
        filterBuyerSelect.innerHTML = '<option value="">Semua Pembeli</option>';

        mitras.forEach(m => {
            // Main filters dropdown
            const opt1 = document.createElement('option');
            opt1.value = m.nama;
            opt1.textContent = m.nama;
            filterBuyerSelect.appendChild(opt1);

            // Modal form dropdown
            const opt2 = document.createElement('option');
            opt2.value = m.id;
            opt2.textContent = m.nama;
            pjMitraSelect.appendChild(opt2);
        });

        // Restore selections if valid
        if (currentSelectedBuyer && mitras.some(m => m.nama === currentSelectedBuyer)) {
            filterBuyerSelect.value = currentSelectedBuyer;
        }
        if (currentSelectedPjMitra && mitras.some(m => m.id == currentSelectedPjMitra)) {
            pjMitraSelect.value = currentSelectedPjMitra;
        }
    }

    /* ============================================================
       Stats Calculation & Update
       ============================================================ */
    function updateStats() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const buyer = document.getElementById('filter-buyer').value;

        let totalVal = 0;
        let cleanVal = 0;
        let totalVol = 0;
        let totalTrans = 0;

        const activeSalesList = getFilteredSales();
        activeSalesList.forEach(s => {
            if (s.status !== 'Dibatalkan') {
                const subTotal = s.volume * s.harga;
                totalVal += subTotal;
                cleanVal += subTotal;
                totalVol += s.volume;
            }
            totalTrans++;
        });

        document.getElementById('stat-total-penjualan').textContent = formatRupiah(totalVal);
        document.getElementById('stat-penjualan-bersih').textContent = formatRupiah(cleanVal);
        document.getElementById('stat-total-volume').innerHTML = `${totalVol.toLocaleString('id-ID')} <span style="color: #068B4A; font-weight: 700; margin-left: 4px;">Liter</span>`;
        document.getElementById('stat-total-transaksi').textContent = totalTrans.toString();

        // ── DYNAMIC MONTH-OVER-MONTH GROWTH CALCULATION ──
        const startD = parseDateString(startVal);
        const M_curr = startD.getMonth();
        const Y_curr = startD.getFullYear();

        const M_prev = M_curr === 0 ? 11 : M_curr - 1;
        const Y_prev = M_curr === 0 ? Y_curr - 1 : Y_curr;

        // Current Month Sums
        let currVal = 0;
        let currVol = 0;
        sales.forEach(s => {
            if (buyer && s.pembeli !== buyer) return;
            const d = parseDateString(s.tanggal);
            if (d.getMonth() === M_curr && d.getFullYear() === Y_curr) {
                if (s.status !== 'Dibatalkan') {
                    currVal += s.volume * s.harga;
                    currVol += s.volume;
                }
            }
        });

        // Previous Month Sums
        let prevVal = 0;
        let prevVol = 0;
        sales.forEach(s => {
            if (buyer && s.pembeli !== buyer) return;
            const d = parseDateString(s.tanggal);
            if (d.getMonth() === M_prev && d.getFullYear() === Y_prev) {
                if (s.status !== 'Dibatalkan') {
                    prevVal += s.volume * s.harga;
                    prevVol += s.volume;
                }
            }
        });

        // Helper to render growth percentage beautifully
        function renderGrowth(elementId, curr, prev) {
            const el = document.getElementById(elementId);
            if (!el) return;
            if (prev === 0) {
                if (curr > 0) {
                    el.className = 'pj-stat-sub pj-stat-sub--up';
                    el.innerHTML = `▲ 100% dari bulan lalu`;
                } else {
                    el.className = 'pj-stat-sub pj-stat-sub--neutral';
                    el.innerHTML = `▲ 0% dari bulan lalu`;
                }
                return;
            }
            const pct = Math.round(((curr - prev) / prev) * 100);
            if (pct > 0) {
                el.className = 'pj-stat-sub pj-stat-sub--up';
                el.innerHTML = `▲ ${pct}% dari bulan lalu`;
            } else if (pct < 0) {
                el.className = 'pj-stat-sub pj-stat-sub--down';
                el.innerHTML = `▼ ${Math.abs(pct)}% dari bulan lalu`;
            } else {
                el.className = 'pj-stat-sub pj-stat-sub--neutral';
                el.innerHTML = `▲ 0% dari bulan lalu`;
            }
        }

        renderGrowth('stat-total-penjualan-growth', currVal, prevVal);
        renderGrowth('stat-penjualan-bersih-growth', currVal, prevVal);
        renderGrowth('stat-total-volume-growth', currVol, prevVol);
    }

    /* ============================================================
       Main Sales Table Rendering & Pagination
       ============================================================ */
    const MAIN_PER_PAGE = 5;
    let mainCurrentPage = 1;

    function getFilteredSales() {
        const startVal = document.getElementById('filter-start-date').value;
        const endVal = document.getElementById('filter-end-date').value;
        const buyer = document.getElementById('filter-buyer').value;

        const startDate = startVal ? parseDateString(startVal) : null;
        const endDate = endVal ? parseDateString(endVal) : null;

        if (endDate) endDate.setHours(23, 59, 59, 999);
        if (startDate) startDate.setHours(0, 0, 0, 0);

        return sales.filter(s => {
            // Check buyer
            if (buyer && s.pembeli !== buyer) return false;

            // Check date range
            if (startDate || endDate) {
                const sDate = parseDateString(s.tanggal);
                if (startDate && sDate < startDate) return false;
                if (endDate && sDate > endDate) return false;
            }

            return true;
        });
    }

    function renderMainTable() {
        const filtered = getFilteredSales();
        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / MAIN_PER_PAGE));

        if (mainCurrentPage > totalPages) mainCurrentPage = totalPages;

        const start = (mainCurrentPage - 1) * MAIN_PER_PAGE;
        const end = Math.min(start + MAIN_PER_PAGE, total);

        const tbody = document.getElementById('pj-table-body');
        tbody.innerHTML = '';

        if (total === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 40px; color: #9CA3AF;">Tidak ada transaksi penjualan dalam filter ini.</td></tr>';
            document.getElementById('pj-main-pagination-info').textContent = 'Tidak ada data';
            document.getElementById('pj-main-pagination-nav').innerHTML = '';
            return;
        }

        const slice = filtered.slice(start, end);
        slice.forEach(s => {
            const tr = document.createElement('tr');
            
            // Format status badge class
            let badgeClass = 'pj-badge--selesai';
            if (s.status === 'Pending') badgeClass = 'pj-badge--pending';
            if (s.status === 'Dibatalkan') badgeClass = 'pj-badge--dibatalkan';

            tr.innerHTML = `
                <td>${s.tanggal}</td>
                <td class="pj-bold">${s.pembeli}</td>
                <td>${s.volume}</td>
                <td>${formatRupiah(s.harga)}</td>
                <td class="pj-bold">${formatRupiah(s.volume * s.harga)}</td>
                <td>${s.metode}</td>
                <td><span class="pj-badge ${badgeClass}">${s.status}</span></td>
                <td>
                    <button class="pj-action-btn" onclick="deleteSales(${s.id})" title="Hapus Transaksi" style="border: 1.5px solid #E5E7EB; border-radius: 8px; width: 34px; height: 34px; background: #FFFFFF; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s;">
                        <img src="{{ asset('images/icons/icontrashmerah.svg') }}" style="width: 18px; height: 18px;" alt="Hapus">
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Update pagination text
        document.getElementById('pj-main-pagination-info').textContent = `Menampilkan ${start + 1} - ${end} dari ${total} Data`;

        // Render Pagination buttons
        const nav = document.getElementById('pj-main-pagination-nav');
        nav.innerHTML = '';

        function makeBtn(label, page, active, disabled) {
            const b = document.createElement('button');
            b.className = 'pj-btn ' + (active ? 'pj-btn--primary' : 'pj-btn--secondary');
            b.style.cssText = 'min-width: 32px; height: 32px; padding: 0 4px; font-size:12px; border-radius:6px; display: inline-flex; align-items: center; justify-content: center;';
            b.textContent = label;
            if (disabled) {
                b.disabled = true;
                b.style.opacity = '0.5';
                b.style.cursor = 'not-allowed';
            } else if (active) {
                b.style.cursor = 'default';
            } else {
                b.addEventListener('click', () => {
                    mainCurrentPage = page;
                    renderMainTable();
                });
            }
            nav.appendChild(b);
        }

        // prev
        makeBtn('\u2039', mainCurrentPage - 1, false, mainCurrentPage === 1);

        for (let p = 1; p <= totalPages; p++) {
            makeBtn(p, p, p === mainCurrentPage, false);
        }

        // next
        makeBtn('\u203A', mainCurrentPage + 1, false, mainCurrentPage === totalPages);
    }

    /* ============================================================
       Mitra Management & Table Rendering & Pagination
       ============================================================ */
    const MITRA_PER_PAGE = 5;
    let mitraCurrentPage = 1;
    let mitraSearchQuery = '';

    function getFilteredMitras() {
        if (!mitraSearchQuery) return mitras;
        const q = mitraSearchQuery.toLowerCase().trim();
        return mitras.filter(m => {
            return m.nama.toLowerCase().includes(q) || 
                   m.kontak.includes(q) || 
                   m.alamat.toLowerCase().includes(q);
        });
    }

    function renderMitraTable() {
        const filtered = getFilteredMitras();
        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / MITRA_PER_PAGE));

        if (mitraCurrentPage > totalPages) mitraCurrentPage = totalPages;

        const start = (mitraCurrentPage - 1) * MITRA_PER_PAGE;
        const end = Math.min(start + MITRA_PER_PAGE, total);

        const tbody = document.getElementById('pj-mitra-table-body');
        tbody.innerHTML = '';

        if (total === 0) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding: 20px; color:#9CA3AF;">Tidak ada mitra ditemukan.</td></tr>';
            document.getElementById('pj-mitra-pagination-info').textContent = 'Tidak ada data';
            document.getElementById('pj-mitra-pagination-nav').innerHTML = '';
            return;
        }

        const slice = filtered.slice(start, end);
        slice.forEach((m, idx) => {
            // Find global index in the original mitras array
            const globalIndex = mitras.findIndex(item => item.id === m.id);

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-weight:700;">${m.nama}</td>
                <td>${m.kontak}</td>
                <td>${m.alamat}</td>
                <td>
                    <div style="display:flex; gap:8px;">
                        <button class="pj-action-btn" onclick="editMitra(${globalIndex})" title="Edit Mitra" style="border: 1.5px solid #E5E7EB; border-radius: 8px; width: 34px; height: 34px; background: #FFFFFF; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s;">
                            <img src="{{ asset('images/icons/iconpensil2.svg') }}" style="width: 18px; height: 18px;" alt="Edit">
                        </button>
                        <button class="pj-action-btn" onclick="deleteMitra(${globalIndex})" title="Hapus Mitra" style="border: 1.5px solid #E5E7EB; border-radius: 8px; width: 34px; height: 34px; background: #FFFFFF; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s;">
                            <img src="{{ asset('images/icons/icontrashmerah.svg') }}" style="width: 18px; height: 18px;" alt="Hapus">
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('pj-mitra-pagination-info').textContent = `Menampilkan ${start + 1} - ${end} dari ${total} data`;

        // Mitra pagination
        const nav = document.getElementById('pj-mitra-pagination-nav');
        nav.innerHTML = '';

        function makeMitraBtn(label, page, active, disabled) {
            const b = document.createElement('button');
            b.className = 'pj-btn ' + (active ? 'pj-btn--primary' : 'pj-btn--secondary');
            b.style.cssText = 'min-width: 28px; height: 28px; padding: 0 4px; font-size:11.5px; border-radius:5px; display: inline-flex; align-items: center; justify-content: center;';
            b.textContent = label;
            if (disabled) {
                b.disabled = true;
                b.style.opacity = '0.5';
                b.style.cursor = 'not-allowed';
            } else if (active) {
                b.style.cursor = 'default';
            } else {
                b.addEventListener('click', () => {
                    mitraCurrentPage = page;
                    renderMitraTable();
                });
            }
            nav.appendChild(b);
        }

        makeMitraBtn('\u2039', mitraCurrentPage - 1, false, mitraCurrentPage === 1);
        for (let p = 1; p <= totalPages; p++) {
            makeMitraBtn(p, p, p === mitraCurrentPage, false);
        }
        makeMitraBtn('\u203A', mitraCurrentPage + 1, false, mitraCurrentPage === totalPages);
    }

    /* ============================================================
       Interactive Add/Edit Sales Actions
       ============================================================ */
    const pjVolume = document.getElementById('input-pj-volume');
    const pjHarga = document.getElementById('input-pj-harga');
    const pjTotal = document.getElementById('input-pj-total');

    function calculateTotal() {
        const vol = parseFloat(pjVolume.value) || 0;
        const harga = parseFloat(pjHarga.value) || 0;
        pjTotal.value = formatRupiah(vol * harga);
    }

    pjVolume.addEventListener('input', calculateTotal);
    pjHarga.addEventListener('input', calculateTotal);

    // Save Penjualan Submit handler
    document.getElementById('form-tambah-penjualan').addEventListener('submit', function(e) {
        e.preventDefault();
        let valid = true;

        const dateField = document.getElementById('input-pj-tanggal');
        const mitraField = document.getElementById('input-pj-mitra');
        const volumeField = document.getElementById('input-pj-volume');
        const hargaField = document.getElementById('input-pj-harga');

        // Validation helper
        function validate(field, cond, errId) {
            const wrap = document.getElementById(errId);
            if (!wrap) return;
            const errSpan = wrap.querySelector('.pj-validation-err');
            if (cond) {
                wrap.classList.remove('pj-field--error');
                if (errSpan) errSpan.style.display = 'none';
            } else {
                wrap.classList.add('pj-field--error');
                if (errSpan) errSpan.style.display = 'block';
                valid = false;
            }
        }

        validate(dateField, dateField.value.trim() !== '', 'field-penjualan-tanggal');
        validate(mitraField, mitraField.value !== '', 'field-penjualan-mitra');
        validate(volumeField, volumeField.value.trim() !== '' && parseFloat(volumeField.value) > 0, 'field-penjualan-volume');
        validate(hargaField, hargaField.value.trim() !== '' && parseFloat(hargaField.value) >= 0, 'field-penjualan-harga');

        if (!valid) return;

        // Convert the date value YYYY-MM-DD from the date input to Indonesian string format
        const formattedDate = formatIndonesianDate(dateField.value);

        // Add to database
        const newSale = {
            tanggal: dateField.value,
            mitra_id: mitraField.value,
            volume: parseFloat(volumeField.value),
            harga: parseFloat(hargaField.value),
            metode: document.getElementById('input-pj-metode').value,
            status: document.getElementById('input-pj-status').value,
            catatan: document.getElementById('input-pj-catatan').value.trim()
        };

        fetch('/owner/penjualan', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newSale)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                sales.unshift(data.data);
                saveState();

                // Close modal
                closeModal('modal-tambah-penjualan');

                // Reset Form
                document.getElementById('form-tambah-penjualan').reset();
                pjTotal.value = "Rp 0";
            } else {
                alert(data.message || 'Gagal menyimpan data penjualan.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menghubungi server.');
        });
    });

    /* ============================================================
       Interactive Add/Edit Mitra Actions
       ============================================================ */
    window.editMitra = function(globalIndex) {
        const m = mitras[globalIndex];
        document.getElementById('modal-mitra-title').textContent = "Edit Mitra / Pembeli";
        document.getElementById('edit-mitra-index').value = globalIndex;
        document.getElementById('edit-mitra-id').value = m.id;
        document.getElementById('input-mitra-nama').value = m.nama;
        document.getElementById('input-mitra-kontak').value = m.kontak;
        document.getElementById('input-mitra-alamat').value = m.alamat;
        document.getElementById('input-mitra-catatan').value = m.catatan || '';

        openModal('modal-tambah-mitra');
    }

    window.deleteMitra = function(globalIndex) {
        const m = mitras[globalIndex];
        if (confirm(`Apakah Anda yakin ingin menghapus mitra "${m.nama}"?`)) {
            fetch(`/owner/mitra/${m.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mitras.splice(globalIndex, 1);
                    saveState();
                } else {
                    alert(data.message || 'Gagal menghapus mitra.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat menghapus mitra.');
            });
        }
    }

    window.deleteSales = function(saleId) {
        if (confirm('Apakah Anda yakin ingin menghapus transaksi penjualan ini?')) {
            fetch(`/owner/penjualan/${saleId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const idx = sales.findIndex(s => s.id === saleId);
                    if (idx !== -1) {
                        sales.splice(idx, 1);
                        saveState();
                    }
                } else {
                    alert(data.message || 'Gagal menghapus transaksi penjualan.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat menghapus transaksi penjualan.');
            });
        }
    }

    const indonesianMonthsShort = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    function formatIndonesianDate(dateVal) {
        if (!dateVal) return '';
        const d = new Date(dateVal);
        if (isNaN(d.getTime())) return dateVal;
        return `${d.getDate().toString().padStart(2, '0')} ${indonesianMonthsShort[d.getMonth()]} ${d.getFullYear()}`;
    }

    // Set up change event listeners for date pickers
    const startDateInput = document.getElementById('filter-start-date');
    const endDateInput = document.getElementById('filter-end-date');

    function syncDateDisplays() {
        document.getElementById('display-start-date').textContent = startDateInput.value ? formatIndonesianDate(startDateInput.value) : 'Semua';
        document.getElementById('display-end-date').textContent = endDateInput.value ? formatIndonesianDate(endDateInput.value) : 'Semua';
    }

    startDateInput.addEventListener('change', syncDateDisplays);
    endDateInput.addEventListener('change', syncDateDisplays);

    // Initial sync
    syncDateDisplays();

    // Save Partner form submit handler
    document.getElementById('form-tambah-mitra').addEventListener('submit', function(e) {
        e.preventDefault();
        let valid = true;

        const nameField = document.getElementById('input-mitra-nama');
        const kontakField = document.getElementById('input-mitra-kontak');
        const alamatField = document.getElementById('input-mitra-alamat');

        function validate(field, cond, errId) {
            const wrap = document.getElementById(errId);
            if (!wrap) return;
            const errSpan = wrap.querySelector('.pj-validation-err');
            if (cond) {
                wrap.classList.remove('pj-field--error');
                if (errSpan) errSpan.style.display = 'none';
            } else {
                wrap.classList.add('pj-field--error');
                if (errSpan) errSpan.style.display = 'block';
                valid = false;
            }
        }

        validate(nameField, nameField.value.trim() !== '', 'field-mitra-nama');
        validate(kontakField, kontakField.value.trim() !== '', 'field-mitra-kontak');
        validate(alamatField, alamatField.value.trim() !== '', 'field-mitra-alamat');

        if (!valid) return;

        const editIndexStr = document.getElementById('edit-mitra-index').value;
        const editIdStr = document.getElementById('edit-mitra-id').value;
        const item = {
            nama: nameField.value.trim(),
            kontak: kontakField.value.trim(),
            alamat: alamatField.value.trim(),
            catatan: document.getElementById('input-mitra-catatan').value.trim()
        };

        const isEdit = editIdStr !== '';
        const url = isEdit ? `/owner/mitra/${editIdStr}` : '/owner/mitra';
        const method = isEdit ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(item)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (isEdit) {
                    const idx = parseInt(editIndexStr);
                    // Update related sales pembeli name locally if name changed
                    const oldName = mitras[idx].nama;
                    sales.forEach(s => {
                        if (s.pembeli === oldName) s.pembeli = data.data.nama;
                    });
                    mitras[idx] = data.data;
                } else {
                    mitras.push(data.data);
                }
                saveState();
                closeModal('modal-tambah-mitra');
                document.getElementById('form-tambah-mitra').reset();
                document.getElementById('edit-mitra-index').value = '';
                document.getElementById('edit-mitra-id').value = '';
            } else {
                alert(data.message || 'Gagal menyimpan data mitra.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menyimpan data mitra.');
        });
    });

    /* ============================================================
       Event Listeners for UI Triggers
       ============================================================ */
    // Open Tambah Penjualan
    document.getElementById('btn-open-tambah-penjualan').addEventListener('click', function() {
        document.getElementById('form-tambah-penjualan').reset();
        pjTotal.value = "Rp 0";
        // Auto pre-fill today's date in YYYY-MM-DD format
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        document.getElementById('input-pj-tanggal').value = `${yyyy}-${mm}-${dd}`;
        openModal('modal-tambah-penjualan');
    });

    // Open Kelola Mitra
    document.getElementById('btn-open-kelola-mitra').addEventListener('click', function() {
        openModal('modal-kelola-mitra');
    });

    // Open Tambah Mitra from list
    document.getElementById('btn-open-tambah-mitra-from-list').addEventListener('click', function() {
        document.getElementById('form-tambah-mitra').reset();
        document.getElementById('edit-mitra-index').value = '';
        document.getElementById('edit-mitra-id').value = '';
        document.getElementById('modal-mitra-title').textContent = "Tambah Mitra / Pembeli";
        openModal('modal-tambah-mitra');
    });

    // Open Tambah Mitra from sales form
    document.getElementById('btn-open-tambah-mitra-from-sales').addEventListener('click', function() {
        document.getElementById('form-tambah-mitra').reset();
        document.getElementById('edit-mitra-index').value = '';
        document.getElementById('edit-mitra-id').value = '';
        document.getElementById('modal-mitra-title').textContent = "Tambah Mitra / Pembeli";
        openModal('modal-tambah-mitra');
    });

    // Search mitra input keyup handler
    document.getElementById('search-mitra-input').addEventListener('input', function(e) {
        mitraSearchQuery = e.target.value;
        mitraCurrentPage = 1;
        renderMitraTable();
    });

    // Filter Apply Trigger
    document.getElementById('btn-apply-filters').addEventListener('click', function() {
        mainCurrentPage = 1;
        renderMainTable();
        updateStats();
    });

    // Reset Filters Trigger
    document.getElementById('btn-reset-filters').addEventListener('click', function() {
        document.getElementById('filter-start-date').value = '';
        document.getElementById('filter-end-date').value = '';
        document.getElementById('filter-buyer').value = '';
        syncDateDisplays();
        mainCurrentPage = 1;
        renderMainTable();
        updateStats();
    });

    // Clear validation error borders on input typing
    document.querySelectorAll('.pj-form-input, .pj-form-select, .pj-form-textarea').forEach(el => {
        el.addEventListener('input', function() {
            const parent = el.closest('.pj-form-field');
            if (parent) parent.classList.remove('pj-field--error');
        });
        el.addEventListener('change', function() {
            const parent = el.closest('.pj-form-field');
            if (parent) parent.classList.remove('pj-field--error');
        });
    });

    /* ============================================================
       Initialization
       ============================================================ */
    populateMitraDropdowns();
    renderMainTable();
    renderMitraTable();
    updateStats();

})();
</script>
@endpush
