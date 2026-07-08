@extends('layouts.karyawan')

@section('title', 'Kesehatan Sapi')
@section('page-title', 'Kesehatan Sapi (Observasi)')
@section('page-subtitle', 'Catat kesehatan sapi berdasarkan observasi harian.')

@push('styles')
<style>
/* ============================================================
   Kesehatan Sapi (Observasi) — Karyawan
   ============================================================ */

/* Page header override */
.ks-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}

.ks-page-header__title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 4px;
}

.ks-page-header__subtitle {
    font-size: 14px;
    font-weight: 400;
    color: #6B7280;
    margin: 0;
}

/* Stat cards row */
.ks-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 20px;
}

.ks-stat-card {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 24px 20px;
    border: 1px solid #E5E7EB;
    display: grid !important;
    grid-template-areas: 
        "icon value"
        ". label"
        ". sub";
    grid-template-columns: auto 1fr;
    grid-template-rows: auto auto auto;
    align-items: center;
    gap: 4px 20px;
    height: 180px;
    box-sizing: border-box;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.ks-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
}

.ks-stat-card__icon {
    grid-area: icon;
    width: 56px !important;
    height: 56px !important;
    flex-shrink: 0;
    align-self: start;
    margin-top: 4px;
}

.ks-stat-card > div {
    display: contents !important;
}

.ks-stat-card__value {
    grid-area: value;
    font-size: 38px !important;
    font-weight: 800;
    line-height: 1;
    margin: 0;
    align-self: center;
    justify-self: start;
}

.ks-stat-card__value--green { color: #124827; }
.ks-stat-card__value--yellow { color: #C99C15; }
.ks-stat-card__value--red { color: #DC2626; }

.ks-stat-card__label {
    grid-area: label;
    font-size: 14px;
    font-weight: 700;
    color: #4B5563;
    margin: 2px 0 0 0;
    align-self: center;
    justify-self: start;
}

.ks-stat-card__sub {
    grid-area: sub;
    font-size: 12px;
    font-weight: 600;
    color: #9CA3AF;
    margin: 4px 0 0 0;
    align-self: center;
    justify-self: start;
    line-height: 1.3;
}

.ks-stat-card__sub--green { color: #059669; }
.ks-stat-card__sub--yellow { color: #D97706; }
.ks-stat-card__sub--red { color: #DC2626; }

/* Data Sapi Section */
.ks-data-section {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    overflow: hidden;
}

.ks-data-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px 18px;
    flex-wrap: wrap;
    gap: 10px;
}

.ks-data-header__title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}

.ks-data-header__actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ks-btn-filter {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: 1px solid #D1D5DB;
    border-radius: 8px;
    background: #FFFFFF;
    color: #374151;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: border-color 0.15s;
}

.ks-btn-filter:hover {
    border-color: #124827;
}

.ks-btn-filter__icon {
    width: 16px;
    height: 16px;
}

.ks-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 20px;
    border: none;
    border-radius: 8px;
    background: #124827;
    color: #FFFFFF;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: background 0.15s, transform 0.1s;
    text-decoration: none;
}

.ks-btn-primary:hover {
    background: #0d3620;
    transform: translateY(-1px);
}

/* Filter Tabs */
.ks-tabs {
    display: flex;
    gap: 0;
    padding: 0 32px;
    border-bottom: 1px solid #E5E7EB;
}

.ks-tab {
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    background: none;
    border-bottom: 3px solid transparent;
    color: #6B7280;
    font-family: 'Manrope', sans-serif;
    transition: color 0.15s, border-color 0.15s, background 0.15s;
    border-radius: 8px 8px 0 0;
    white-space: nowrap;
}

.ks-tab:hover {
    color: #124827;
}

.ks-tab--active {
    background: #124827;
    color: #FFFFFF;
    border-radius: 8px;
    margin-bottom: 4px;
    margin-top: 4px;
    border-bottom: none;
}

.ks-tab--yellow {
    color: #D97706;
}

.ks-tab--red {
    color: #DC2626;
}

/* Data Table */
.ks-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.ks-table th {
    text-align: left;
    font-weight: 800;
    color: #111827;
    padding: 16px 32px;
    border-bottom: 2px solid #E5E7EB;
    font-size: 14px;
    white-space: nowrap;
}

.ks-table td {
    padding: 18px 32px;
    color: #374151;
    border-bottom: 1px solid #F3F4F6;
    font-size: 15px;
    vertical-align: middle;
}

.ks-table tr:last-child td {
    border-bottom: none;
}

.ks-table tr:hover td {
    background: #F9FAFB;
}

/* Sapi info cell */
.ks-sapi-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.ks-sapi-thumb-img {
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    object-fit: contain;
}

.ks-sapi-name {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    line-height: 1.2;
}

.ks-sapi-id {
    font-size: 13px;
    color: #9CA3AF;
    font-weight: 500;
}

/* Status badges */
.ks-badge {
    display: inline-block;
    font-size: 14px;
    font-weight: 800;
    white-space: nowrap;
}

.ks-badge--normal {
    color: #124827;
}

.ks-badge--warning {
    color: #D97706;
}

.ks-badge--danger {
    color: #DC2626;
}

/* Text color helpers */
.ks-text--yellow { color: #D97706; }
.ks-text--red { color: #DC2626; }

/* Catatan cell */
.ks-catatan {
    font-size: 12px;
    color: #6B7280;
    max-width: 180px;
}

.ks-catatan__date {
    font-weight: 600;
    color: #374151;
    display: block;
    margin-bottom: 2px;
}

/* Action button */
.ks-btn-edit {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    border-radius: 6px;
    transition: background 0.15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.ks-btn-edit:hover {
    background: #F3F4F6;
}

.ks-btn-edit__icon {
    width: 18px;
    height: 18px;
}

/* Empty state */
.ks-empty {
    text-align: center;
    padding: 64px 24px;
    color: #9CA3AF;
}

.ks-empty__icon {
    font-size: 44px;
    margin-bottom: 14px;
}

.ks-empty__title {
    font-size: 17px;
    font-weight: 700;
    color: #374151;
    margin: 0 0 6px;
}

.ks-empty__sub {
    font-size: 13px;
    font-weight: 400;
    margin: 0;
}

/* ── Pagination footer ──────────────────────────────────── */
.ks-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px 28px;
    border-top: 1px solid #F3F4F6;
    gap: 12px;
    flex-wrap: wrap;
}

.ks-pagination-info {
    font-size: 13px;
    font-weight: 600;
    color: #6B7280;
    white-space: nowrap;
}

.ks-pagination-nav {
    display: flex;
    align-items: center;
    gap: 4px;
}

.ks-page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 6px;
    border-radius: 8px;
    border: 1.5px solid #E5E7EB;
    background: #FFFFFF;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: background 0.15s, color 0.15s, border-color 0.15s, transform 0.1s;
    user-select: none;
    line-height: 1;
}

.ks-page-btn:hover:not(:disabled):not(.ks-page-btn--active) {
    background: #F3F4F6;
    border-color: #D1D5DB;
    transform: translateY(-1px);
}

.ks-page-btn--active {
    background: #124827;
    border-color: #124827;
    color: #FFFFFF;
    cursor: default;
}

.ks-page-btn--arrow {
    color: #374151;
    font-size: 15px;
    font-weight: 900;
}

.ks-page-btn--arrow:disabled {
    opacity: 0.3;
    cursor: not-allowed;
    transform: none;
}

.ks-page-btn--ellipsis {
    border-color: transparent;
    background: transparent;
    cursor: default;
    color: #9CA3AF;
    font-size: 14px;
    letter-spacing: 1px;
}

.ks-page-btn--ellipsis:hover {
    background: transparent;
    transform: none;
}

/* Dropdown Aksi */
.ks-action-dropdown {
    display: none;
    position: absolute;
    right: 24px;
    top: 70%;
    background: #FFFFFF;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    z-index: 100;
    width: 170px;
    padding: 6px 0;
}

.ks-dropdown-item {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 8px 16px;
    border: none;
    background: none;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    text-align: left;
    font-family: 'Manrope', sans-serif;
    transition: background 0.12s;
}

.ks-dropdown-item:hover {
    background: #F9FAFB;
}

.ks-dropdown-item--danger {
    color: #DC2626;
}

.ks-dropdown-item img {
    flex-shrink: 0;
}

/* Modal Observasi */
.obs-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.obs-modal-content {
    background: #D9D9D9;
    border-radius: 16px;
    border: 1px solid #7F7F7F;
    width: 100%;
    max-width: 440px;
    padding: 24px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    position: relative;
    font-family: 'Manrope', sans-serif;
}

.obs-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.obs-modal-title {
    font-size: 18px;
    font-weight: 800;
    color: #000000;
    margin: 0;
    display: flex;
    align-items: center;
}

.obs-modal-close {
    background: none;
    border: none;
    font-size: 28px;
    color: #000000;
    font-weight: 800;
    cursor: pointer;
    padding: 0;
    transition: opacity 0.15s;
    line-height: 1;
}

.obs-modal-close:hover {
    opacity: 0.7;
}

.obs-form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 14px;
}

.obs-form-group label {
    font-size: 13.5px;
    font-weight: 700;
    color: #555555;
    margin-bottom: 6px;
}

/* Wrapper input dengan icon kiri */
.obs-input-wrapper {
    position: relative;
    width: 100%;
}

.obs-input-wrapper input,
.obs-input-wrapper select {
    width: 100%;
    padding: 10px 36px 10px 40px; /* space for left icon & right arrow */
    border: 1px solid #7F7F7F;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    font-family: 'Manrope', sans-serif;
    color: #000000;
    background: #FFFFFF;
    box-sizing: border-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    transition: border-color 0.15s;
}

/* Khusus text area */
.obs-form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #7F7F7F;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    font-family: 'Manrope', sans-serif;
    color: #000000;
    background: #FFFFFF;
    box-sizing: border-box;
    transition: border-color 0.15s;
    resize: vertical;
}

.obs-input-wrapper input:focus,
.obs-input-wrapper select:focus,
.obs-form-group textarea:focus {
    outline: none;
    border-color: #124827;
}

/* Left Icon styling */
.obs-left-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.obs-left-icon img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* Right Chevron for custom select dropdowns */
.obs-chevron {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    color: #000000;
    pointer-events: none;
    stroke-width: 3.5;
}

/* Colored dot for Kondisi status */
.obs-status-dot {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #10B981;
    pointer-events: none;
}

.obs-form-row {
    display: flex;
    gap: 16px;
}

.flex-1 {
    flex: 1;
    min-width: 0;
}

.obs-datetime-wrap {
    display: flex;
    gap: 12px;
    width: 100%;
}

.obs-datetime-wrap .obs-input-wrapper {
    flex: 1;
    min-width: 0;
}

.obs-datetime-wrap input {
    padding-right: 12px !important; /* date/time fields don't need right chevron space */
}

.obs-form-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 24px;
    gap: 16px;
}

.obs-btn-cancel {
    flex: 1;
    padding: 10px 24px;
    border: 1px solid #7F7F7F;
    background: #FFFFFF;
    color: #000000;
    font-size: 14px;
    font-weight: 700;
    border-radius: 8px;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: background 0.15s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

.obs-btn-cancel:hover {
    background: #F3F4F6;
}

.obs-btn-save {
    flex: 1.3;
    padding: 10.5px 24px;
    border: none;
    background: #124827;
    color: #FFFFFF;
    font-size: 14px;
    font-weight: 700;
    border-radius: 8px;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: background 0.15s;
}

.obs-btn-save:hover {
    background: #0d3620;
}

/* Responsive */
@media (max-width: 1024px) {
    .ks-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .ks-stats {
        grid-template-columns: 1fr;
    }

    .ks-table {
        font-size: 12px;
    }

    .ks-table th,
    .ks-table td {
        padding: 10px 12px;
    }

    .ks-tabs {
        overflow-x: auto;
        padding: 0 16px;
    }
}

/* Hybrid Searchable Dropdown Styles */
.hybrid-select-wrapper {
    position: relative;
    width: 100%;
}
.hybrid-select-display {
    width: 100%;
    padding: 10px 36px 10px 14px;
    border: 1.5px solid #7F7F7F; /* match theme */
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #000000;
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
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    font-weight: 800;
    color: #000000;
    pointer-events: none;
}
.hybrid-select-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #FFFFFF;
    border: 1px solid #7F7F7F;
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
    border: 1.5px solid #7F7F7F;
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

@if(session('success'))
    <div style="background: #DEF7EC; color: #03543F; padding: 16px 24px; border-radius: 12px; margin-bottom: 20px; font-size: 14.5px; font-weight: 700; display: flex; align-items: center; gap: 10px; font-family: 'Manrope', sans-serif;">
        <svg viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px; flex-shrink:0;">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: #FDE8E8; color: #9B1C1C; padding: 16px 24px; border-radius: 12px; margin-bottom: 20px; font-size: 14.5px; font-weight: 700; font-family: 'Manrope', sans-serif;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Stat Cards --}}
<div class="ks-stats">

    <div class="ks-stat-card">
        <img src="{{ asset('images/icons/iconsapihijaucarddashboard.svg') }}" alt="" class="ks-stat-card__icon">
        <div>
            <div class="ks-stat-card__value ks-stat-card__value--green">{{ $countSemua }}</div>
            <div class="ks-stat-card__label">Total Sapi</div>
            <div class="ks-stat-card__sub">Semua Sapi</div>
        </div>
    </div>

    <div class="ks-stat-card">
        <img src="{{ asset('images/icons/hearthijau.png') }}" alt="" class="ks-stat-card__icon">
        <div>
            <div class="ks-stat-card__value ks-stat-card__value--green">{{ $countNormal }}</div>
            <div class="ks-stat-card__label">Sapi Sehat</div>
            <div class="ks-stat-card__sub ks-stat-card__sub--green">{{ $countSemua > 0 ? round(($countNormal / $countSemua) * 100) : 0 }}% dari keseluruhan</div>
        </div>
    </div>

    <div class="ks-stat-card">
        <img src="{{ asset('images/icons/heart kuning.png') }}" alt="" class="ks-stat-card__icon">
        <div>
            <div class="ks-stat-card__value ks-stat-card__value--yellow">{{ $countPemantauan }}</div>
            <div class="ks-stat-card__label">Perlu Pemantauan</div>
            <div class="ks-stat-card__sub ks-stat-card__sub--yellow">{{ $countSemua > 0 ? round(($countPemantauan / $countSemua) * 100) : 0 }}% dari keseluruhan</div>
        </div>
    </div>

    <div class="ks-stat-card">
        <img src="{{ asset('images/icons/heartmerah.png') }}" alt="" class="ks-stat-card__icon">
        <div>
            <div class="ks-stat-card__value ks-stat-card__value--red">{{ $countTindakan }}</div>
            <div class="ks-stat-card__label">Perlu Tindakan</div>
            <div class="ks-stat-card__sub ks-stat-card__sub--red">{{ $countSemua > 0 ? round(($countTindakan / $countSemua) * 100) : 0 }}% dari keseluruhan</div>
        </div>
    </div>

</div>

{{-- Data Sapi Section --}}
<div class="ks-data-section">

    {{-- Header with actions --}}
    <div class="ks-data-header">
        <h2 class="ks-data-header__title">Data Sapi</h2>
        <div class="ks-data-header__actions">
            <button class="ks-btn-filter">
                <img src="{{ asset('images/icons/iconfilter.svg') }}" alt="" class="ks-btn-filter__icon">
                Filter
            </button>
            <button type="button" class="ks-btn-primary" onclick="openSapiModal()" style="background: #124827; margin-right: 6px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Sapi Baru
            </button>
            <button type="button" class="ks-btn-primary" onclick="openCreateModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Catat Observasi
            </button>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="ks-tabs" role="tablist">
        <button class="ks-tab ks-tab--active" id="tab-semua" role="tab" aria-selected="true" onclick="setTab(this,'semua')">Semua ({{ $countSemua }})</button>
        <button class="ks-tab" id="tab-normal" role="tab" aria-selected="false" onclick="setTab(this,'normal')">Normal ({{ $countNormal }})</button>
        <button class="ks-tab ks-tab--yellow" id="tab-pemantauan" role="tab" aria-selected="false" onclick="setTab(this,'pemantauan')">Perlu Pemantauan ({{ $countPemantauan }})</button>
        <button class="ks-tab ks-tab--red" id="tab-tindakan" role="tab" aria-selected="false" onclick="setTab(this,'tindakan')">Perlu Tindakan ({{ $countTindakan }})</button>
    </div>

    {{-- Data Table --}}
    <table class="ks-table">
        <thead>
            <tr>
                <th>Daftar Sapi</th>
                <th>Nafsu Makan</th>
                <th>Kondisi Susu</th>
                <th>Perilaku</th>
                <th>Catatan Terakhir</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="ks-tbody">
            @forelse($sapis as $sapi)
                @php
                    $latest = $sapi->kesehatan->first();
                    $statusClass = 'normal';
                    if ($sapi->status === 'perlu_pemantauan') $statusClass = 'pemantauan';
                    if ($sapi->status === 'perlu_tindakan') $statusClass = 'tindakan';
                @endphp
                <tr class="ks-row" data-status="{{ $statusClass }}">
                    <td>
                        <div class="ks-sapi-info">
                            <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="" class="ks-sapi-thumb-img">
                            <div>
                                <div class="ks-sapi-name">{{ $sapi->name }}</div>
                                <div class="ks-sapi-id">{{ $sapi->code }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($latest && $latest->nafsu_makan === 'Baik')
                            <span class="ks-val ks-val--good">Baik</span>
                        @elseif($latest && $latest->nafsu_makan === 'Kurang')
                            <span class="ks-val ks-val--low">Kurang</span>
                        @else
                            <span class="ks-val">-</span>
                        @endif
                    </td>
                    <td>
                        @if($latest && $latest->kondisi_susu === 'Normal')
                            <span class="ks-val ks-val--normal">Normal</span>
                        @elseif($latest && $latest->kondisi_susu === 'Bermasalah')
                            <span class="ks-val ks-val--low">Bermasalah</span>
                        @else
                            <span class="ks-val">-</span>
                        @endif
                    </td>
                    <td>
                        @if($latest && $latest->perilaku === 'Aktif')
                            <span class="ks-val ks-val--active">Aktif</span>
                        @elseif($latest && $latest->perilaku === 'Lesu')
                            <span class="ks-val ks-val--lethargic">Lesu</span>
                        @else
                            <span class="ks-val">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="ks-catatan">
                            @if($latest)
                                <span class="ks-catatan__date">{{ $latest->created_at->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                {{ Str::limit($latest->catatan, 35) }}
                            @else
                                <span class="ks-catatan__date">—</span>
                                Belum ada catatan
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($sapi->status === 'normal')
                            <span class="ks-badge ks-badge--normal">Normal</span>
                        @elseif($sapi->status === 'perlu_pemantauan')
                            <span class="ks-badge ks-badge--warning">Perlu Pemantauan</span>
                        @else
                            <span class="ks-badge ks-badge--danger">Perlu Tindakan</span>
                        @endif
                    </td>
                    <td style="position: relative;">
                        <button type="button" class="ks-btn-edit" title="Aksi" onclick="toggleDropdown(this, event)">
                            <img src="{{ asset('images/icons/iconedit.svg') }}" alt="Aksi" class="ks-btn-edit__icon">
                        </button>
                        <div class="ks-action-dropdown" style="display:none;">
                            <button type="button" class="ks-dropdown-item" onclick="openEditModal({{ $sapi->id }}, '{{ $sapi->name }}', '{{ $sapi->code }}', '{{ $latest ? $latest->id : '' }}', '{{ $latest ? $latest->nafsu_makan : 'Baik' }}', '{{ $latest ? $latest->kondisi_susu : 'Normal' }}', '{{ $latest ? $latest->perilaku : 'Aktif' }}', '{{ $latest ? $latest->status : 'Normal' }}', '{{ $latest ? $latest->catatan : '' }}', '{{ $latest ? $latest->created_at->format('Y-m-d') : now()->format('Y-m-d') }}', '{{ $latest ? $latest->created_at->format('H:i') : now()->format('H:i') }}')">
                                <img src="{{ asset('images/icons/iconpensil.svg') }}" alt="" style="width:14px; height:14px; margin-right:8px; filter: grayscale(1);">
                                Edit Observasi
                            </button>
                            @if($latest)
                                <form action="{{ route('karyawan.kesehatan.destroy', $latest->id) }}" method="POST" onsubmit="return confirm('Hapus observasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ks-dropdown-item ks-dropdown-item--danger">
                                        <img src="{{ asset('images/icons/icontrashmerah.svg') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
                                        Hapus Observasi
                                    </button>
                                </form>
                            @endif
                            <button type="button" class="ks-dropdown-item" style="border-top: 1px solid #F3F4F6;" onclick="openEditSapiModal({{ $sapi->id }}, '{{ trim($sapi->name) }}', '{{ trim($sapi->code) }}', '{{ $sapi->status }}')">
                                <img src="{{ asset('images/icons/iconpensil.svg') }}" alt="" style="width:14px; height:14px; margin-right:8px; filter: grayscale(1);">
                                Edit Sapi
                            </button>
                            <form action="{{ route('karyawan.sapi.destroy', $sapi->id) }}" method="POST" onsubmit="return confirm('Hapus Sapi ini? Semua data observasi & produksi sapi ini juga akan dihapus secara permanen.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ks-dropdown-item ks-dropdown-item--danger" style="border-top: 1px solid #F3F4F6;">
                                    <img src="{{ asset('images/icons/icontrashmerah.svg') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
                                    Hapus Sapi
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr id="ks-empty-row">
                    <td colspan="7">
                        <div class="ks-empty">
                            <h4 class="ks-empty__title">Tidak ada data sapi</h4>
                            <p class="ks-empty__sub">Data sapi saat ini kosong atau belum dimasukkan.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Pagination bar ── --}}
    <div class="ks-pagination-bar" id="ks-pagination-bar">
        <span class="ks-pagination-info" id="ks-pagination-info">Menampilkan 0 - 0 dari 0 Data</span>
        <nav class="ks-pagination-nav" id="ks-pagination-nav" aria-label="Navigasi halaman"></nav>
    </div>

</div>

{{-- Modal Form Catat/Edit Observasi --}}
<div id="obsModal" class="obs-modal-overlay" style="display: none;">
    <div class="obs-modal-content">
        <div class="obs-modal-header">
            <h3 class="obs-modal-title">
                <img src="{{ asset('images/icons/iconpensil2.svg') }}" style="width:20px; height:20px; margin-right:8px; vertical-align:middle;">
                <span id="modalTitleText" style="vertical-align:middle;">Catat Observasi</span>
            </h3>
            <button type="button" class="obs-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form id="obsForm" action="{{ route('karyawan.kesehatan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="obs-form-group">
                <label for="formSapi">Sapi</label>
                <div class="obs-input-wrapper">
                    <div class="obs-left-icon">
                        <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="">
                    </div>
                    <select name="sapi_id" id="formSapi" required>
                        <option value="" disabled selected>Pilih Sapi</option>
                        @foreach($sapis as $sapi)
                            <option value="{{ $sapi->id }}">{{ $sapi->name }} ({{ $sapi->code }})</option>
                        @endforeach
                    </select>
                    <svg class="obs-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            <div class="obs-form-group">
                <label>Tanggal & Waktu</label>
                <div class="obs-datetime-wrap">
                    <div class="obs-input-wrapper">
                        <div class="obs-left-icon">
                            <img src="{{ asset('images/icons/icon kalender.svg') }}" alt="">
                        </div>
                        <input type="date" name="tanggal" id="formTanggal" required>
                    </div>
                    <div class="obs-input-wrapper">
                        <div class="obs-left-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:16px; height:16px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <input type="time" name="waktu" id="formWaktu" required>
                    </div>
                </div>
            </div>

            <div class="obs-form-group">
                <label for="formKondisi">Kondisi</label>
                <div class="obs-input-wrapper">
                    <span id="kondisiDot" class="obs-status-dot"></span>
                    <select name="status" id="formKondisi" onchange="updateKondisiDot(this.value)" required>
                        <option value="Normal">Normal</option>
                        <option value="Perlu Pemantauan">Perlu Pemantauan</option>
                        <option value="Perlu Tindakan">Perlu Tindakan</option>
                    </select>
                    <svg class="obs-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            <div class="obs-form-row">
                <div class="obs-form-group flex-1">
                    <label for="formNafsuMakan">Nafsu Makan</label>
                    <div class="obs-input-wrapper">
                        <select name="nafsu_makan" id="formNafsuMakan" required>
                            <option value="Baik">Baik</option>
                            <option value="Kurang">Kurang</option>
                        </select>
                        <svg class="obs-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
                <div class="obs-form-group flex-1">
                    <label for="formSusu">Susu</label>
                    <div class="obs-input-wrapper">
                        <select name="kondisi_susu" id="formSusu" required>
                            <option value="Normal">Normal</option>
                            <option value="Bermasalah">Bermasalah</option>
                        </select>
                        <svg class="obs-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
            </div>

            <div class="obs-form-group">
                <label for="formPerilaku">Perilaku</label>
                <div class="obs-input-wrapper">
                    <select name="perilaku" id="formPerilaku" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Lesu">Lesu</option>
                    </select>
                    <svg class="obs-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            <div class="obs-form-group">
                <label for="formCatatan">Catatan (Opsional)</label>
                <textarea name="catatan" id="formCatatan" placeholder="Masukkan catatan" rows="3"></textarea>
            </div>

            <div class="obs-form-actions">
                <button type="button" class="obs-btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" id="btnSubmit" class="obs-btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Form Tambah & Edit Sapi --}}
<div id="sapiModal" class="obs-modal-overlay" style="display: none;">
    <div class="obs-modal-content" style="background: #E5E7EB; border: 1px solid #7F7F7F; border-radius: 12px; max-width: 400px; padding: 24px;">
        <div class="obs-modal-header" style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
            <h3 class="obs-modal-title" style="font-size: 16.5px; font-weight: 800; color: #000000; display: flex; align-items: center; gap: 8px; margin: 0;">
                <img src="{{ asset('images/icons/iconpensil2.svg') }}" style="width:16px; height:16px;" alt="">
                <span id="sapiModalTitleText">Tambah Data Sapi</span>
            </h3>
            <button type="button" class="obs-modal-close" onclick="closeSapiModal()" style="font-size: 24px; font-weight: 800; color: #000000; border: none; background: none; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <form id="sapiForm" action="" method="POST">
            @csrf
            <input type="hidden" name="_method" id="sapiFormMethod" value="POST">
            
            <div class="obs-form-group" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #000000; margin-bottom: 6px; display: block;">ID Sapi <span style="color: #EF0000;">*</span></label>
                <div class="obs-input-wrapper">
                    <input type="text" name="code" id="sapiFormCode" required placeholder="Contoh SP001" style="padding: 10px 14px; border: 1.5px solid #7F7F7F; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Manrope', sans-serif; color: #000000; background: #FFFFFF; width: 100%; box-sizing: border-box;">
                </div>
            </div>

            <div class="obs-form-group" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #000000; margin-bottom: 6px; display: block;">Nama Sapi <span style="color: #EF0000;">*</span></label>
                <div class="obs-input-wrapper">
                    <input type="text" name="name" id="sapiFormName" required placeholder="Contoh Sapi 1" style="padding: 10px 14px; border: 1.5px solid #7F7F7F; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Manrope', sans-serif; color: #000000; background: #FFFFFF; width: 100%; box-sizing: border-box;">
                </div>
            </div>

            <div class="obs-form-group" style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #000000; margin-bottom: 6px; display: block;">Status <span style="color: #EF0000;">*</span></label>
                <div class="obs-input-wrapper">
                    <select name="status" id="sapiFormStatus" required style="padding: 10px 36px 10px 14px; border: 1.5px solid #7F7F7F; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Manrope', sans-serif; color: #000000; background: #FFFFFF; width: 100%; box-sizing: border-box; -webkit-appearance: none; -moz-appearance: none; appearance: none;">
                        <option value="Normal" selected>Normal</option>
                        <option value="Perlu Pemantauan">Perlu Pemantauan</option>
                        <option value="Perlu Tindakan">Perlu Tindakan</option>
                    </select>
                    <svg class="obs-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="right: 12px; width: 16px; height: 16px; color: #000000; pointer-events: none; position: absolute; top: 50%; transform: translateY(-50%);"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            <div class="obs-form-actions" style="margin-top: 20px; display: flex; gap: 12px;">
                <button type="button" class="obs-btn-cancel" onclick="closeSapiModal()" style="flex: 1; padding: 10px 20px; border: 1.5px solid #7F7F7F; background: #FFFFFF; color: #000000; font-size: 14px; font-weight: 700; border-radius: 8px; cursor: pointer; text-align: center;">Batal</button>
                <button type="submit" id="sapiBtnSubmit" class="obs-btn-save" style="flex: 1.2; padding: 10.5px 20px; border: none; background: #124827; color: #FFFFFF; font-size: 14px; font-weight: 700; border-radius: 8px; cursor: pointer; text-align: center;">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    /* ── Config ───────────────────────────────────────────────── */
    const PER_PAGE = 5;

    /* ── State ────────────────────────────────────────────────── */
    let currentFilter = 'semua';
    let currentPage   = 1;

    /* ── DOM refs ─────────────────────────────────────────────── */
    const allRows   = Array.from(document.querySelectorAll('#ks-tbody tr.ks-row'));
    const tabs      = document.querySelectorAll('.ks-tab');
    const infoEl    = document.getElementById('ks-pagination-info');
    const navEl     = document.getElementById('ks-pagination-nav');

    /* ── Helpers ──────────────────────────────────────────────── */
    function getVisible() {
        if (currentFilter === 'semua') return allRows;
        return allRows.filter(r => r.dataset.status === currentFilter);
    }

    function render() {
        const visible    = getVisible();
        const total      = visible.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));

        // Clamp current page
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * PER_PAGE;  // 0-indexed
        const end   = Math.min(start + PER_PAGE, total);

        // Hide ALL rows first
        allRows.forEach(r => (r.style.display = 'none'));

        // Handle empty row
        const emptyRow = document.getElementById('ks-empty-row');
        if (emptyRow) {
            emptyRow.style.display = total === 0 ? '' : 'none';
        }

        // Show only the current page slice of visible rows
        visible.forEach((r, i) => {
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // ── Info text ──────────────────────────────────────────
        infoEl.textContent = total === 0
            ? 'Tidak ada data'
            : `Menampilkan ${start + 1} - ${end} dari ${total} Data`;

        // ── Page buttons ───────────────────────────────────────
        navEl.innerHTML = '';

        function btn(label, page, cls, disabled) {
            const b = document.createElement('button');
            b.className = 'ks-page-btn ' + (cls || '');
            b.textContent = label;
            b.setAttribute('aria-label', label);
            if (disabled) b.disabled = true;
            if (page !== null && !disabled) {
                b.addEventListener('click', function () {
                    currentPage = page;
                    render();
                });
            }
            navEl.appendChild(b);
        }

        // Prev arrow
        btn('\u2039', currentPage - 1, 'ks-page-btn--arrow', currentPage === 1);

        // Page number logic with ellipsis
        const delta = 1; // pages around current
        let pages = [];
        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentPage - delta && p <= currentPage + delta)) {
                pages.push(p);
            }
        }

        let prev = null;
        pages.forEach(function (p) {
            if (prev !== null && p - prev > 1) {
                // ellipsis gap
                const e = document.createElement('button');
                e.className = 'ks-page-btn ks-page-btn--ellipsis';
                e.textContent = '...';
                e.disabled = true;
                navEl.appendChild(e);
            }
            btn(p, p, p === currentPage ? 'ks-page-btn--active' : '', false);
            prev = p;
        });

        // Next arrow
        btn('\u203A', currentPage + 1, 'ks-page-btn--arrow', currentPage === totalPages || total === 0);
    }

    /* ── Tab switching ────────────────────────────────────────── */
    function setTab(el, filter) {
        currentFilter = filter;
        currentPage   = 1;

        // Reset all tab styles
        tabs.forEach(function (t) {
            t.classList.remove('ks-tab--active');
            if (t.id === 'tab-normal')     t.classList.add('ks-tab--normal');
            if (t.id === 'tab-pemantauan') t.classList.add('ks-tab--yellow');
            if (t.id === 'tab-tindakan')   t.classList.add('ks-tab--red');
            t.setAttribute('aria-selected', 'false');
        });

        el.classList.add('ks-tab--active');
        el.classList.remove('ks-tab--yellow', 'ks-tab--red');
        el.setAttribute('aria-selected', 'true');

        render();
    }

    /* ── Dropdown and Modal Handling ──────────────────────────── */
    function toggleDropdown(btn, event) {
        event.stopPropagation();
        const dropdown = btn.nextElementSibling;
        const isCurrentlyOpen = dropdown.style.display === 'block';
        
        // Close all other dropdowns
        document.querySelectorAll('.ks-action-dropdown').forEach(el => el.style.display = 'none');
        
        // Toggle this one
        dropdown.style.display = isCurrentlyOpen ? 'none' : 'block';
    }

    function updateKondisiDot(status) {
        const dot = document.getElementById('kondisiDot');
        if (!dot) return;
        const norm = String(status).toLowerCase().replace(/_/g, ' ').trim();
        if (norm === 'normal') {
            dot.style.backgroundColor = '#10B981';
        } else if (norm === 'perlu pemantauan') {
            dot.style.backgroundColor = '#F59E0B';
        } else if (norm === 'perlu tindakan') {
            dot.style.backgroundColor = '#EF4444';
        } else {
            dot.style.backgroundColor = '#10B981';
        }
    }

    function openCreateModal() {
        const modal = document.getElementById('obsModal');
        const form = document.getElementById('obsForm');
        const titleText = document.getElementById('modalTitleText');
        const methodInput = document.getElementById('formMethod');
        const btnSubmit = document.getElementById('btnSubmit');

        // Close dropdowns
        document.querySelectorAll('.ks-action-dropdown').forEach(el => el.style.display = 'none');

        // Reset form
        form.reset();
        
        // Setup Create Mode
        titleText.textContent = 'Catat Observasi';
        form.action = "{{ route('karyawan.kesehatan.store') }}";
        methodInput.value = 'POST';
        btnSubmit.textContent = 'Simpan';

        // Enable sapi select
        document.getElementById('formSapi').disabled = false;
        updateSearchableSelect('formSapi');

        // Set default date & time to today & now
        const now = new Date();
        const todayStr = now.toISOString().split('T')[0];
        const timeStr = now.toTimeString().split(' ')[0].substring(0, 5);
        document.getElementById('formTanggal').value = todayStr;
        document.getElementById('formWaktu').value = timeStr;

        // Reset Kondisi Dot
        updateKondisiDot('Normal');

        // Display modal
        modal.style.display = 'flex';
    }

    function openEditModal(sapiId, name, code, latestId, nafsu, susu, perilaku, status, catatan, tanggal, waktu) {
        const modal = document.getElementById('obsModal');
        const form = document.getElementById('obsForm');
        const titleText = document.getElementById('modalTitleText');
        const methodInput = document.getElementById('formMethod');
        const btnSubmit = document.getElementById('btnSubmit');

        // Close dropdowns
        document.querySelectorAll('.ks-action-dropdown').forEach(el => el.style.display = 'none');

        // Setup Edit Mode
        titleText.textContent = 'Edit Observasi';
        
        // Action will point to update route
        if (latestId) {
            form.action = `/karyawan/kesehatan/${latestId}`;
            methodInput.value = 'PUT';
            btnSubmit.textContent = 'Simpan Perubahan';
        } else {
            // If no prior observation, treat as store
            form.action = "{{ route('karyawan.kesehatan.store') }}";
            methodInput.value = 'POST';
            btnSubmit.textContent = 'Simpan';
        }

        // Set values
        document.getElementById('formSapi').value = sapiId;
        updateSearchableSelect('formSapi');
        document.getElementById('formTanggal').value = tanggal;
        document.getElementById('formWaktu').value = waktu;
        document.getElementById('formKondisi').value = status;
        document.getElementById('formNafsuMakan').value = nafsu;
        document.getElementById('formSusu').value = susu;
        document.getElementById('formPerilaku').value = perilaku;
        document.getElementById('formCatatan').value = catatan;

        // Update Kondisi Dot to match prefilled status
        updateKondisiDot(status);

        // Display modal
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('obsModal').style.display = 'none';
    }

    function openSapiModal() {
        const modal = document.getElementById('sapiModal');
        const form = document.getElementById('sapiForm');
        const titleText = document.getElementById('sapiModalTitleText');
        const methodInput = document.getElementById('sapiFormMethod');
        const btnSubmit = document.getElementById('sapiBtnSubmit');

        document.querySelectorAll('.ks-action-dropdown').forEach(el => el.style.display = 'none');
        form.reset();

        titleText.textContent = 'Tambah Data Sapi';
        form.action = "{{ route('karyawan.sapi.store') }}";
        methodInput.value = 'POST';
        btnSubmit.textContent = 'Simpan';

        document.getElementById('sapiFormCode').readOnly = false;
        modal.style.display = 'flex';
    }

    function openEditSapiModal(id, name, code, status) {
        const modal = document.getElementById('sapiModal');
        const form = document.getElementById('sapiForm');
        const titleText = document.getElementById('sapiModalTitleText');
        const methodInput = document.getElementById('sapiFormMethod');
        const btnSubmit = document.getElementById('sapiBtnSubmit');

        document.querySelectorAll('.ks-action-dropdown').forEach(el => el.style.display = 'none');

        titleText.textContent = 'Edit Data Sapi';
        form.action = `/karyawan/sapi/${id}`;
        methodInput.value = 'PUT';
        btnSubmit.textContent = 'Simpan Perubahan';

        document.getElementById('sapiFormCode').value = code;
        document.getElementById('sapiFormCode').readOnly = true; // Code/ID sapi is fix and cannot be edited
        document.getElementById('sapiFormName').value = name;
        
        let normalizedStatus = 'Normal';
        if (status === 'perlu_pemantauan') normalizedStatus = 'Perlu Pemantauan';
        if (status === 'perlu_tindakan') normalizedStatus = 'Perlu Tindakan';
        document.getElementById('sapiFormStatus').value = normalizedStatus;

        modal.style.display = 'flex';
    }

    function closeSapiModal() {
        document.getElementById('sapiModal').style.display = 'none';
    }

    // Global listener to close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.ks-btn-edit') && !e.target.closest('.ks-action-dropdown')) {
            document.querySelectorAll('.ks-action-dropdown').forEach(el => el.style.display = 'none');
        }
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
        display.textContent = selectedOpt ? selectedOpt.textContent : 'Pilih Sapi';
        
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

    // Expose to window scope
    window.toggleDropdown = toggleDropdown;
    window.openCreateModal = openCreateModal;
    window.openEditModal = openEditModal;
    window.closeModal = closeModal;
    window.openSapiModal = openSapiModal;
    window.openEditSapiModal = openEditSapiModal;
    window.closeSapiModal = closeSapiModal;
    window.setTab = setTab;
    window.updateKondisiDot = updateKondisiDot;

    // Initialize searchable dropdown
    initSearchableDropdown('formSapi', 'Cari Sapi...');

    // ── Initial render ─────────────────────────────────────────
    render();

    /* ── Sync title ───────────────────────────────────────────── */
    document.title = "Kesehatan Sapi | Parman Farm";

})();
</script>
@endpush
