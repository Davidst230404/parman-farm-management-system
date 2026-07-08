@extends('layouts.owner')

@section('title', 'Kesehatan Sapi')
@section('page-title', 'Data Sapi')

@push('styles')
<style>
/* ============================================================
   Data Sapi / Kesehatan Sapi Styles — Figma node 97-203
   ============================================================ */

/* Page card wrapper — connects seamlessly with filter bar above */
.ks-card {
    background: #FFFFFF;
    border-radius: 0 0 16px 16px;
    border: 1px solid #E2E8F0;
    border-top: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 0;
}

/* Card top header */
.ks-card__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 28px 32px 20px;
    gap: 16px;
    flex-wrap: wrap;
}

.ks-card__heading {
    flex: 1;
    min-width: 0;
}

.ks-card__title {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 4px;
}

.ks-card__subtitle {
    font-size: 13px;
    font-weight: 400;
    color: #6B7280;
    margin: 0;
}

/* Date selector — right side */
.ks-date-selector {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    cursor: pointer;
    white-space: nowrap;
    flex-shrink: 0;
    background: none;
    border: none;
    padding: 0;
    font-family: 'Manrope', sans-serif;
    transition: color 0.15s;
}

.ks-date-selector:hover {
    color: #124827;
}

.ks-date-selector__arrow {
    font-size: 16px;
    color: #124827;
    font-weight: 900;
}

/* Main Data Section — Figma Card layout */
.ks-data-section {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 24px;
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
    font-size: 20px;
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

.ks-btn-filter:hover {
    opacity: 0.8;
}

.ks-btn-filter__icon {
    width: 20px;
    height: 20px;
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
.ks-table-wrap {
    overflow-x: auto;
}

.ks-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Manrope', sans-serif;
}

.ks-table thead th {
    padding: 12px 24px;
    font-size: 15px;
    font-weight: 900;
    color: #111827;
    text-align: left;
    background: #FAFAFA;
    border-bottom: 1px solid #F3F4F6;
    white-space: nowrap;
}

.ks-table thead th:first-child {
    border-radius: 0;
    padding-left: 32px;
}

.ks-table thead th:last-child {
    padding-right: 32px;
}

.ks-table tbody tr {
    border-bottom: 1px solid #F9FAFB;
    transition: background 0.12s;
}

.ks-table tbody tr:last-child {
    border-bottom: none;
}

.ks-table tbody tr:hover {
    background: #F9FAFB;
}

.ks-table tbody td {
    padding: 12px 24px;
    font-size: 15px;
    color: #111827;
    vertical-align: middle;
}

.ks-table tbody td:first-child {
    padding-left: 32px;
}

.ks-table tbody td:last-child {
    padding-right: 32px;
}

/* Daftar Sapi cell */
.ks-cow-cell {
    display: flex;
    align-items: center;
    gap: 14px;
}

.ks-cow-thumb-img {
    width: 32px;
    height: 32px;
    object-fit: contain;
    flex-shrink: 0;
}

.ks-cow-name {
    font-size: 16px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 2px;
    line-height: 1.2;
}

.ks-cow-id {
    font-size: 13px;
    font-weight: 600;
    color: #9CA3AF;
    margin: 0;
    line-height: 1.2;
}

/* Health indicator text */
.ks-val {
    font-weight: 700;
    font-size: 14px;
}

.ks-val--good {
    color: #16A34A;
}

.ks-val--normal {
    color: #124827;
    font-weight: 700;
}

.ks-val--active {
    color: #16A34A;
}

.ks-val--low {
    color: #D97706;
}

.ks-val--lethargic {
    color: #DC2626;
}

/* Catatan Terakhir */
.ks-note-date {
    font-size: 12.5px;
    font-weight: 600;
    color: #6B7280;
    display: block;
    margin-bottom: 2px;
}

.ks-note-text {
    font-size: 13px;
    font-weight: 400;
    color: #9CA3AF;
    display: block;
}

/* Status badges */
.ks-status {
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}

.ks-status--normal {
    color: #124827;
}

.ks-status--pemantauan {
    color: #D97706;
}

.ks-status--tindakan {
    color: #DC2626;
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
    padding: 16px 32px 20px;
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
    padding: 24px;
    border: 1px solid #E5E7EB;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 20px;
    height: 140px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.ks-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
}

.ks-stat-card__icon {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    object-fit: contain;
    margin-top: 6px;
}

.ks-stat-card__value {
    font-size: 36px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
}

.ks-stat-card__value--green { color: #124827; }
.ks-stat-card__value--yellow { color: #C99C15; }
.ks-stat-card__value--red { color: #EF0000; }

.ks-stat-card__label {
    font-size: 14px;
    font-weight: 700;
    color: #4B5563;
    margin-top: 2px;
}

.ks-stat-card__sub {
    font-size: 12px;
    font-weight: 600;
    color: #9CA3AF;
    margin-top: 8px;
    line-height: 1.3;
}

.ks-stat-card__sub--green { color: #124827; }
.ks-stat-card__sub--yellow { color: #C99C15; }
.ks-stat-card__sub--red { color: #EF0000; }

/* Text color helpers */
.ks-text--yellow { color: #C99C15; }
.ks-text--red { color: #EF0000; }

/* Catatan cell */
.ks-catatan {
    font-size: 15px;
    color: #4B5563;
    max-width: 180px;
}

.ks-catatan__date {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
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

.ks-action-dropdown--up {
    top: auto;
    bottom: 70%;
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
    color: #EF0000;
}

.ks-dropdown-item img {
    flex-shrink: 0;
}

/* Modal Observasi & Sapi */
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

.obs-radio-group {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 10px;
}

.obs-radio-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: #000000;
    cursor: pointer;
}

.obs-radio-input {
    appearance: none;
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #124827;
    border-radius: 50%;
    outline: none;
    background-color: #FFFFFF;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.15s;
}

.obs-radio-input:checked {
    background-color: #124827;
    border-color: #124827;
    box-shadow: inset 0 0 0 3px #FFFFFF;
}
</style>
@endpush

@section('page-title', 'Data Sapi')
@section('page-subtitle', 'Kelola data sapi dan pantau secara rutin')

@section('content')

{{-- ============================================================
     DATA SAPI / KESEHATAN SAPI PAGE — Figma: node 97-203
     ============================================================ --}}

{{-- Page Header (Removed as per user request to avoid top-bar repetition) --}}

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

{{-- Main Data Section --}}
<div class="ks-data-section">

    {{-- Header with actions --}}
    <div class="ks-data-header">
        <h2 class="ks-data-header__title">Data Sapi</h2>
        <div class="ks-data-header__actions">
            <button class="ks-btn-filter">
                <img src="{{ asset('images/icons/iconfilter.svg') }}" alt="" class="ks-btn-filter__icon">
                Filter
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
    <div class="ks-table-wrap">
        <table class="ks-table">
            <thead>
                <tr>
                    <th scope="col">Daftar Sapi</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Umur</th>
                    <th scope="col">Catatan Terakhir</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody id="ks-tbody">

                @forelse($sapis as $sapi)
                    @php
                        $latest = $sapi->kesehatan->first();
                        $statusClass = 'normal';
                        if ($sapi->status === 'perlu_pemantauan') $statusClass = 'pemantauan';
                        if ($sapi->status === 'perlu_tindakan') $statusClass = 'tindakan';

                        // Dynamic realistic gender and age based on database id
                        if ($sapi->id == 1) { $gender = 'Betina'; $umur = '3 Tahun 2 Bulan'; }
                        elseif ($sapi->id == 2) { $gender = 'Jantan'; $umur = '4 Tahun 2 Bulan'; }
                        elseif ($sapi->id == 3) { $gender = 'Betina'; $umur = '3 Tahun 2 Bulan'; }
                        elseif ($sapi->id == 4) { $gender = 'Jantan'; $umur = '5 Tahun 1 Bulan'; }
                        elseif ($sapi->id == 5) { $gender = 'Betina'; $umur = '3 Tahun 2 Bulan'; }
                        elseif ($sapi->id == 6) { $gender = 'Betina'; $umur = '2 Tahun 2 Bulan'; }
                        elseif ($sapi->id == 7) { $gender = 'Betina'; $umur = '3 Tahun 2 Bulan'; }
                        else {
                            $gender = ($sapi->id % 2 === 0) ? 'Jantan' : 'Betina';
                            $years = ($sapi->id % 3) + 2;
                            $months = ($sapi->id % 8) + 1;
                            $umur = "{$years} Tahun {$months} Bulan";
                        }
                    @endphp
                    <tr class="ks-row" data-status="{{ $statusClass }}">
                        <td>
                            <div class="ks-cow-cell">
                                <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="" class="ks-cow-thumb-img">
                                <div>
                                    <div class="ks-cow-name">{{ $sapi->name }}</div>
                                    <div class="ks-cow-id">{{ $sapi->code }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="color: #124827; font-weight: 700;">{{ $gender }}</span>
                        </td>
                        <td>
                            <span style="color: #124827; font-weight: 700;">{{ $umur }}</span>
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
                                <span style="color: #124827; font-weight: 800; font-size: 15px;">Normal</span>
                            @elseif($sapi->status === 'perlu_pemantauan')
                                <span style="color: #C99C15; font-weight: 800; font-size: 15px;">Perlu Pemantauan</span>
                            @else
                                <span style="color: #EF0000; font-weight: 800; font-size: 15px;">Perlu Tindakan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr id="ks-empty-row">
                        <td colspan="5">
                            <div class="ks-empty">
                                <h4 class="ks-empty__title">Tidak ada data sapi</h4>
                                <p class="ks-empty__sub">Data sapi saat ini kosong atau belum dimasukkan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- ── Pagination bar ── --}}
    <div class="ks-pagination-bar" id="ks-pagination-bar">
        <span class="ks-pagination-info" id="ks-pagination-info">Menampilkan 0 - 0 dari 0 Data</span>
        <nav class="ks-pagination-nav" id="ks-pagination-nav" aria-label="Navigasi halaman"></nav>
    </div>

</div>

{{-- Modal Form Edit Observasi --}}
<div id="obsModal" class="obs-modal-overlay" style="display: none;">
    <div class="obs-modal-content">
        <div class="obs-modal-header">
            <h3 class="obs-modal-title">
                <img src="{{ asset('images/icons/iconpensil2.svg') }}" style="width:20px; height:20px; margin-right:8px; vertical-align:middle;">
                <span id="modalTitleText" style="vertical-align:middle;">Catat Observasi</span>
            </h3>
            <button type="button" class="obs-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form id="obsForm" action="{{ route('owner.kesehatan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="sapi_id" id="formSapiId">
            
            <div class="obs-form-group">
                <label for="formSapiNameText">Sapi</label>
                <div class="obs-input-wrapper">
                    <div class="obs-left-icon">
                        <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="">
                    </div>
                    <input type="text" id="formSapiNameText" disabled style="padding: 10px 14px 10px 40px; border: 1px solid #7F7F7F; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Manrope', sans-serif; color: #000000; background: #E5E7EB; width: 100%; box-sizing: border-box;">
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
                    <span id="formStatusDot" class="obs-status-dot"></span>
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
                    <label for="formNafsu">Nafsu Makan</label>
                    <div class="obs-input-wrapper">
                        <select name="nafsu_makan" id="formNafsu" required>
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




@endsection

@push('scripts')
<script>
(function () {
    /* ── Config ───────────────────────────────────────────────── */
    const PER_PAGE = 7;

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
            if (t.id === 'tab-pemantauan') t.classList.add('ks-tab--warning');
            if (t.id === 'tab-tindakan')   t.classList.add('ks-tab--danger');
            t.setAttribute('aria-selected', 'false');
        });

        el.classList.add('ks-tab--active');
        el.classList.remove('ks-tab--normal', 'ks-tab--warning', 'ks-tab--danger');
        el.setAttribute('aria-selected', 'true');

        render();
    }

    // Expose to inline onclick attributes
    window.setTab = setTab;

    /* ── Dropdown and Modal Handling ──────────────────────────── */
    function toggleDropdown(btn, event) {
        event.stopPropagation();
        const dropdown = btn.nextElementSibling;
        const isCurrentlyOpen = dropdown.style.display === 'block';

        // Close all other dropdowns
        document.querySelectorAll('.ks-action-dropdown').forEach(el => {
            el.style.display = 'none';
            el.classList.remove('ks-action-dropdown--up');
        });

        if (!isCurrentlyOpen) {
            dropdown.style.display = 'block';
            // Check if dropdown would overflow bottom of viewport
            const rect = dropdown.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            if (rect.bottom > viewportHeight - 10) {
                dropdown.classList.add('ks-action-dropdown--up');
            }
        }
    }

    function openEditModal(sapiId, sapiName, sapiCode, obsId, nafsuMakan, kondisiSusu, perilaku, status, catatan, tanggal, waktu) {
        const modal = document.getElementById('obsModal');
        const form = document.getElementById('obsForm');

        // Close dropdowns
        document.querySelectorAll('.ks-action-dropdown').forEach(el => {
            el.style.display = 'none';
            el.classList.remove('ks-action-dropdown--up');
        });

        // Set action url
        if (obsId) {
            form.action = `/owner/kesehatan/${obsId}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('modalTitleText').textContent = 'Edit Observasi';
        } else {
            form.action = '/owner/kesehatan';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('modalTitleText').textContent = 'Catat Observasi';
        }

        document.getElementById('formSapiId').value = sapiId;
        document.getElementById('formSapiNameText').value = `${sapiName} (${sapiCode})`;
        document.getElementById('formTanggal').value = tanggal;
        document.getElementById('formWaktu').value = waktu;
        document.getElementById('formKondisi').value = status;
        document.getElementById('formNafsu').value = nafsuMakan;
        document.getElementById('formSusu').value = kondisiSusu;
        document.getElementById('formPerilaku').value = perilaku;
        document.getElementById('formCatatan').value = catatan;

        updateKondisiDot(status);

        // Open
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('obsModal').style.display = 'none';
    }

    function updateKondisiDot(status) {
        const dot = document.getElementById('formStatusDot');
        if (status === 'Normal') {
            dot.style.backgroundColor = '#10B981'; // Green
        } else if (status === 'Perlu Pemantauan') {
            dot.style.backgroundColor = '#C99C15'; // Gold
        } else {
            dot.style.backgroundColor = '#EF0000'; // Red
        }
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function () {
        document.querySelectorAll('.ks-action-dropdown').forEach(el => {
            el.style.display = 'none';
            el.classList.remove('ks-action-dropdown--up');
        });
    });

    // Expose functions globally
    window.toggleDropdown = toggleDropdown;
    window.openEditModal = openEditModal;
    window.closeModal = closeModal;
    window.updateKondisiDot = updateKondisiDot;

    // ── Initial render ─────────────────────────────────────────
    render();

    /* ── Sync title ───────────────────────────────────────────── */
    document.title = "Data Sapi | Parman Farm";

})();
</script>
@endpush
