@extends('layouts.karyawan')

@section('title', 'Produksi Susu')
@section('page-title', 'Produksi Susu (Pemerahan)')
@section('page-subtitle', 'Catat pemerahan sapi pagi dan sore.')

@push('styles')
<style>
/* Font import */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

.owner-body {
    font-family: 'Manrope', sans-serif;
}

/* Page Header */
.kp-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.kp-page-header__title {
    font-size: 24px;
    font-weight: 800;
    color: #124827;
    margin: 0 0 4px;
}

.kp-page-header__sub {
    font-size: 13px;
    color: #6B7280;
    margin: 0;
}

/* Stats Grid */
.kp-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 20px;
}

.kp-stat-card {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #E5E7EB;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 20px;
    height: 180px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.kp-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
}

.kp-stat-card__icon {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    object-fit: contain;
    margin-top: 6px;
}

.kp-stat-card__content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.kp-stat-card__value {
    font-size: 36px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
    white-space: nowrap;
}

.kp-stat-card__value--green { color: #124827; }
.kp-stat-card__value--purple { color: #8027BA; }
.kp-stat-card__value--yellow { color: #C99C15; }
.kp-stat-card__value--blue { color: #272FCF; }

.kp-stat-card__value-unit {
    font-size: 36px;
    font-weight: 800;
    margin-left: 2px;
}

.kp-stat-card__label {
    font-size: 14px;
    font-weight: 700;
    color: #4B5563;
    margin-top: 2px;
}

.kp-stat-card__sub {
    font-size: 12px;
    font-weight: 600;
    color: #9CA3AF;
    margin-top: 8px;
    line-height: 1.3;
}

/* Input Form Section */
.kp-form-section {
    background: #FFFFFF;
    border-radius: 12px;
    border: 1px solid #E5E7EB;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.kp-form-title {
    font-size: 16px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 16px;
}

/* Horizontal Form Grid */
.kp-form-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr) auto;
    gap: 16px;
    align-items: flex-end;
}

.kp-form-group {
    display: flex;
    flex-direction: column;
}

.kp-form-group label {
    font-size: 12px;
    font-weight: 700;
    color: #555555;
    margin-bottom: 6px;
}

/* Input Wrappers with Left Icons */
.kp-input-wrapper {
    position: relative;
    width: 100%;
}

.kp-input-wrapper input,
.kp-input-wrapper select {
    width: 100%;
    padding: 10px 12px 10px 38px;
    border: 1px solid #D1D5DB;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    background: #F9FAFB;
    box-sizing: border-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    transition: border-color 0.15s, background-color 0.15s;
    height: 42px;
}

.kp-input-wrapper input:focus,
.kp-input-wrapper select:focus {
    outline: none;
    border-color: #124827;
    background-color: #FFFFFF;
}

.kp-left-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.kp-left-icon img,
.kp-left-icon svg {
    max-width: 100%;
    max-height: 100%;
}

.kp-chevron {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 14px;
    height: 14px;
    color: #6B7280;
    pointer-events: none;
    stroke-width: 3.5;
}

/* Suffix for Liter Input */
.kp-input-suffix-wrapper {
    position: relative;
    width: 100%;
}

.kp-input-suffix-wrapper input {
    width: 100%;
    padding: 10px 32px 10px 14px; /* normal left padding, space for R suffix */
    border: 1px solid #D1D5DB;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    background: #F9FAFB;
    box-sizing: border-box;
    height: 42px;
}

.kp-input-suffix-wrapper input:focus {
    outline: none;
    border-color: #124827;
    background-color: #FFFFFF;
}

.kp-suffix {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    font-weight: 700;
    color: #6B7280;
    pointer-events: none;
}

/* Primary Button */
.kp-btn-primary {
    background: #124827;
    color: #FFFFFF;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.15s;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
}

.kp-btn-primary:hover {
    background: #0d3620;
}

/* Data Section */
.kp-data-section {
    background: #FFFFFF;
    border-radius: 12px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}


/* ── Riwayat Header: title top, controls below ──────────── */
.kp-riwayat-header {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 18px 24px 14px;
    border-bottom: 1px solid #E5E7EB;
    gap: 12px;
}

.kp-data-header__title {
    font-size: 17px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    white-space: nowrap;
}

/* Row with all controls: space-between left filters and right buttons */
.kp-riwayat-controls-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    width: 100%;
}

.kp-riwayat-filters-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.kp-riwayat-filters-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

/* Left group: title + filter dropdowns */
.kp-riwayat-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

/* Right group: Filter button + Lihat Laporan */
.kp-riwayat-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

/* Inline date range picker */
.kp-inline-date-range {
    display: flex;
    align-items: center;
    background: #FFFFFF;
    border: 1px solid #D1D5DB;
    border-radius: 8px;
    padding: 0 10px;
    height: 38px;
    gap: 4px;
}

.kp-inline-date {
    border: none;
    outline: none;
    font-size: 12px;
    font-weight: 600;
    font-family: 'Manrope', sans-serif;
    color: #374151;
    background: transparent;
    width: 120px;
    cursor: pointer;
}

.kp-date-sep {
    font-size: 12px;
    color: #9CA3AF;
    font-weight: 600;
    padding: 0 2px;
}

/* Inline select dropdowns */
.kp-inline-select-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.kp-inline-select {
    padding: 0 32px 0 12px;
    border: 1px solid #D1D5DB;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Manrope', sans-serif;
    color: #374151;
    background: #FFFFFF;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    height: 38px;
    min-width: 130px;
    cursor: pointer;
}

.kp-inline-select:focus {
    outline: none;
    border-color: #124827;
}

.kp-inline-chevron {
    position: absolute;
    right: 8px;
    width: 14px;
    height: 14px;
    stroke-width: 2.5;
    color: #9CA3AF;
    pointer-events: none;
}

/* Filter button */
.kp-filter-btn {
    padding: 0 14px;
    border: 1px solid #D1D5DB;
    background: #FFFFFF;
    color: #374151;
    font-size: 13px;
    font-weight: 700;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    height: 38px;
    transition: background-color 0.15s;
    font-family: 'Manrope', sans-serif;
}

.kp-filter-btn:hover {
    background-color: #F3F4F6;
}



.kp-laporan-btn {
    padding: 8px 16px;
    border: none;
    background: #124827;
    color: #FFFFFF;
    font-size: 13px;
    font-weight: 700;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    height: 36px;
    align-self: flex-end;
    transition: background-color 0.15s;
}

.kp-laporan-btn:hover {
    background-color: #0d3620;
}

.kp-laporan-btn img {
    width: 14px;
    height: 14px;
}

/* Date Range Inputs Wrapper */
.kp-date-range-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
}

.kp-date-range-to {
    font-size: 12px;
    font-weight: 700;
    color: #6B7280;
    align-self: flex-end;
    margin-bottom: 10px;
}

/* Table styling */
.kp-table-container {
    width: 100%;
    overflow-x: auto;
}

.kp-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    text-align: left;
    font-size: 14px;
}

.kp-table th {
    background: #CECFD2;
    padding: 14px 20px;
    font-weight: 800;
    color: #111827;
    border-bottom: 1px solid #D1D5DB;
    font-size: 13px;
    text-transform: none;
    letter-spacing: 0;
    vertical-align: top;
}

.kp-table th:first-child {
    border-radius: 10px 0 0 0;
}

.kp-table th:last-child {
    border-radius: 0 10px 0 0;
}

.kp-table td {
    padding: 18px 20px;
    border-bottom: 1px solid #F3F4F6;
    color: #111827;
    font-weight: 500;
    font-size: 15px;
    vertical-align: top;
}

.kp-table tbody tr:hover {
    background: #F9FAFB;
}

/* Session Icon styling */
.kp-session-cell {
    display: flex;
    align-items: center;
    gap: 8px;
}

.kp-session-icon {
    width: 18px;
    height: 18px;
}

/* Badges */
.kp-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 700;
    border-radius: 6px;
}

.kp-badge--success {
    background: #DEF7EC;
    color: #03543F;
}

/* Edit & Actions */
.kp-btn-action {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    border-radius: 6px;
    transition: background-color 0.15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.kp-btn-action:hover {
    background: #F3F4F6;
}

.kp-btn-action img {
    width: 18px;
    height: 18px;
}

/* Context Dropdown menu */
.kp-action-dropdown {
    display: none;
    position: absolute;
    right: 24px;
    top: 70%;
    background: #FFFFFF;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    z-index: 100;
    width: 160px;
    padding: 6px 0;
}

/* Dropdown opens upward for last row */
.kp-action-dropdown--up {
    top: auto;
    bottom: 70%;
}


.kp-dropdown-item {
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

.kp-dropdown-item:hover {
    background: #F9FAFB;
}

.kp-dropdown-item--danger {
    color: #DC2626;
}

/* Pagination bar */
.kp-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px 28px;
    border-top: 1px solid #F3F4F6;
}

.kp-pagination-info {
    font-size: 13px;
    font-weight: 600;
    color: #6B7280;
}

.kp-pagination-nav {
    display: flex;
    gap: 6px;
}

.kp-page-btn {
    padding: 6px 12px;
    border: 1px solid #E5E7EB;
    background: #FFFFFF;
    color: #374151;
    font-size: 13px;
    font-weight: 700;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.15s;
    min-width: 32px;
    text-align: center;
}

.kp-page-btn:hover {
    background: #F9FAFB;
    border-color: #D1D5DB;
}

.kp-page-btn--active {
    background: #124827;
    border-color: #124827;
    color: #FFFFFF;
    cursor: default;
}

.kp-page-btn--arrow {
    color: #374151;
    font-size: 14px;
    font-weight: 900;
}

.kp-page-btn--arrow:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.kp-page-btn--ellipsis {
    border-color: transparent;
    background: transparent;
    cursor: default;
    color: #9CA3AF;
    min-width: auto;
}

/* Empty state */
.kp-empty {
    text-align: center;
    padding: 48px 24px;
    color: #9CA3AF;
}

.kp-empty__title {
    font-size: 15px;
    font-weight: 700;
    color: #374151;
    margin: 0 0 4px;
}

.kp-empty__sub {
    font-size: 12.5px;
    margin: 0;
}

/* ───────────────────────────────────────────────────────────── */
/* Modal Form Edit Produksi - Background #D9D9D9                 */
/* ───────────────────────────────────────────────────────────── */
.kp-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.kp-modal-content {
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

.kp-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.kp-modal-title {
    font-size: 18px;
    font-weight: 800;
    color: #000000;
    margin: 0;
    display: flex;
    align-items: center;
}

.kp-modal-close {
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

.kp-modal-close:hover {
    opacity: 0.7;
}

/* Modal Form Fields */
.kp-modal-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 14px;
}

.kp-modal-group label {
    font-size: 13.5px;
    font-weight: 700;
    color: #555555;
    margin-bottom: 6px;
}

.kp-modal-input-wrapper {
    position: relative;
    width: 100%;
}

.kp-modal-input-wrapper input,
.kp-modal-input-wrapper select {
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
    height: 42px;
}

.kp-modal-input-wrapper input:focus,
.kp-modal-input-wrapper select:focus {
    outline: none;
    border-color: #124827;
}

/* Modals inputs without chevrons (date/time/number) */
.kp-modal-input-no-chevron {
    padding-right: 12px !important;
}

.kp-modal-left-icon {
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

.kp-modal-left-icon img,
.kp-modal-left-icon svg {
    max-width: 100%;
    max-height: 100%;
}

.kp-modal-chevron {
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

.kp-modal-suffix {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    font-weight: 700;
    color: #000000;
    pointer-events: none;
}

.kp-modal-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 24px;
    gap: 16px;
}

.kp-modal-btn-cancel {
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
    height: 42px;
    text-align: center;
}

.kp-modal-btn-cancel:hover {
    background: #F3F4F6;
}

.kp-modal-btn-save {
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
    height: 42px;
    text-align: center;
}

.kp-modal-btn-save:hover {
    background: #0d3620;
}

/* Sesi toggle buttons */
.kp-sesi-toggle {
    display: flex;
    gap: 10px;
}

.kp-sesi-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 10px 14px;
    background: #FFFFFF;
    border: 1px solid #7F7F7F;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Manrope', sans-serif;
    color: #374151;
    cursor: pointer;
    transition: all 0.15s;
    height: 42px;
}

.kp-sesi-btn-icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

.kp-sesi-radio {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #7F7F7F;
    display: inline-block;
    flex-shrink: 0;
    transition: all 0.15s;
    background: #FFFFFF;
}

.kp-sesi-btn--active {
    border-color: #124827;
    background: #FFFFFF;
    color: #124827;
}

.kp-sesi-btn--active .kp-sesi-radio {
    border-color: #124827;
    background: #124827;
    box-shadow: inset 0 0 0 3px #FFFFFF;
}


/* Responsive */
@media (max-width: 1024px) {
    .kp-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    .kp-form-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }
    .kp-form-row button {
        grid-column: span 2;
    }
}

@media (max-width: 640px) {
    .kp-stats {
        grid-template-columns: 1fr;
    }
    .kp-form-row {
        grid-template-columns: 1fr;
    }
    .kp-form-row button {
        grid-column: span 1;
    }
    .kp-filters-bar {
        flex-direction: column;
        align-items: stretch;
    }
    .kp-filter-btn {
        width: 100%;
        justify-content: center;
    }
    .kp-pagination-bar {
        flex-direction: column;
        gap: 12px;
        align-items: center;
    }
}
/* Laporan Button in table header */
.kp-btn-laporan {
    background: #124827;
    color: #FFFFFF;
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    transition: background 0.15s;
    font-family: 'Manrope', sans-serif;
}

.kp-btn-laporan:hover {
    background: #0d3620;
}

/* Sapi cell in table */
.kp-sapi-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.kp-sapi-icon {
    width: 32px;
    height: 32px;
    flex-shrink: 0;
    object-fit: contain;
}

.kp-sapi-name {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    line-height: 1.2;
}

.kp-sapi-code {
    font-size: 12px;
    color: #9CA3AF;
    font-weight: 500;
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

{{-- Alert status success --}}
@if(session('success'))
    <div style="background: #DEF7EC; border: 1.5px solid #03543F; color: #03543F; padding: 14px 20px; border-radius: 8px; font-weight: 700; font-size: 14px; margin-bottom: 20px; font-family: 'Manrope', sans-serif;">
        {{ session('success') }}
    </div>
@endif

{{-- 4 Stat Cards --}}
<div class="kp-stats">

    <div class="kp-stat-card">
        <img src="{{ asset('images/icons/iconsapihijaucarddashboard.svg') }}" alt="Total Sapi" class="kp-stat-card__icon">
        <div class="kp-stat-card__content">
            <div class="kp-stat-card__value kp-stat-card__value--green" id="stat-total-sapi">{{ number_format($totalSapi, 0, ',', '.') }}</div>
            <div class="kp-stat-card__label">Total Sapi</div>
            <div class="kp-stat-card__sub" id="label-sapi">Semua Sapi</div>
        </div>
    </div>

    <div class="kp-stat-card">
        <img src="{{ asset('images/icons/iconbotolungu1.svg') }}" alt="Total Minggu Ini" class="kp-stat-card__icon">
        <div class="kp-stat-card__content">
            <div class="kp-stat-card__value kp-stat-card__value--purple" id="stat-weekly-production">{{ number_format($weeklyProduction, 0, ',', '.') }}<span class="kp-stat-card__value-unit">L</span></div>
            <div class="kp-stat-card__label">Produksi</div>
            <div class="kp-stat-card__sub" id="label-weekly">Total Minggu Ini</div>
        </div>
    </div>

    <div class="kp-stat-card">
        <img src="{{ asset('images/icons/icondatakuning.svg') }}" alt="Total Bulan Ini" class="kp-stat-card__icon">
        <div class="kp-stat-card__content">
            <div class="kp-stat-card__value kp-stat-card__value--yellow" id="stat-monthly-production">{{ number_format($monthlyProduction, 0, ',', '.') }}<span class="kp-stat-card__value-unit">L</span></div>
            <div class="kp-stat-card__label">Produksi</div>
            <div class="kp-stat-card__sub" id="label-monthly">Total Bulan Ini</div>
        </div>
    </div>

    <div class="kp-stat-card">
        <img src="{{ asset('images/icons/iconbotolsusubiru.svg') }}" alt="Total Hari Ini" class="kp-stat-card__icon" style="filter: invert(15%) sepia(90%) saturate(3000%) hue-rotate(225deg) brightness(80%) contrast(110%);">
        <div class="kp-stat-card__content">
            <div class="kp-stat-card__value kp-stat-card__value--blue" id="stat-today-production">{{ number_format($todayProduction, 0, ',', '.') }}<span class="kp-stat-card__value-unit">L</span></div>
            <div class="kp-stat-card__label">Produksi</div>
            <div class="kp-stat-card__sub" id="label-today">Total Hari Ini</div>
        </div>
    </div>

</div>

{{-- Input Form Section --}}
<div class="kp-form-section">
    <h2 class="kp-form-title">Input Produksi Susu Hari Ini</h2>
    <form action="{{ route('karyawan.produksi.store') }}" method="POST">
        @csrf
        <div class="kp-form-row">
            {{-- Tanggal --}}
            <div class="kp-form-group">
                <label for="inputTanggal">Tanggal</label>
                <div class="kp-input-wrapper">
                    <div class="kp-left-icon">
                        <img src="{{ asset('images/icons/icon kalender.svg') }}" alt="">
                    </div>
                    <input type="date" name="tanggal" id="inputTanggal" value="{{ now()->format('Y-m-d') }}" required>
                </div>
            </div>

            {{-- Sesi --}}
            <div class="kp-form-group">
                <label for="inputSesi">Sesi</label>
                <div class="kp-input-wrapper">
                    <div class="kp-left-icon" id="sesiIconWrap">
                        <img id="sesiIcon" src="{{ asset('images/icons/iconmatahari.svg') }}" alt="" style="width:16px; height:16px;">
                    </div>
                    <select name="sesi" id="inputSesi" required>
                        <option value="pagi">Pagi</option>
                        <option value="sore">Sore</option>
                    </select>
                    <svg class="kp-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            {{-- Pilih Sapi --}}
            <div class="kp-form-group">
                <label for="inputSapi">Pilih Sapi</label>
                <div class="kp-input-wrapper">
                    <div class="kp-left-icon">
                        <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="" style="width:18px; height:18px;">
                    </div>
                    <select name="sapi_id" id="inputSapi" required>
                        <option value="" disabled selected>Pilih Sapi</option>
                        @foreach($sapis as $sapi)
                            <option value="{{ $sapi->id }}">{{ $sapi->name }} ({{ $sapi->code }})</option>
                        @endforeach
                    </select>
                    <svg class="kp-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            {{-- Jumlah Susu (Liter) --}}
            <div class="kp-form-group">
                <label for="inputJumlah">Jumlah Susu</label>
                <div class="kp-input-suffix-wrapper">
                    <input type="number" name="jumlah_susu" id="inputJumlah" placeholder="Masukkan jumlah" step="any" required>
                    <span class="kp-suffix">L</span>
                </div>
            </div>

            {{-- Button --}}
            <button type="submit" class="kp-btn-primary">
                <img src="{{ asset('images/icons/iconbutonsimpan.svg') }}" alt="" style="width:16px; height:16px; margin-right:6px; filter: brightness(0) invert(1);">
                Simpan
            </button>
        </div>
    </form>
</div>

{{-- Riwayat Table Section --}}
<div class="kp-data-section">
    {{-- Header: title on top, all controls on second row --}}
    <div class="kp-riwayat-header">
        <h2 class="kp-data-header__title">Riwayat Produksi</h2>

        <div class="kp-riwayat-controls-row">
            {{-- LEFT: date range + dropdowns --}}
            <div class="kp-riwayat-filters-left">
                {{-- Date range picker --}}
                <div class="kp-inline-date-range">
                    <img src="{{ asset('images/icons/icon kalender.svg') }}" alt="" style="width:14px; height:14px; opacity:0.55; flex-shrink:0;">
                    <input type="date" id="filterTanggalMulai" class="kp-inline-date" title="Tanggal Mulai">
                    <span class="kp-date-sep">-</span>
                    <input type="date" id="filterTanggalSelesai" class="kp-inline-date" title="Tanggal Selesai">
                </div>

                {{-- Sapi dropdown --}}
                <div class="kp-inline-select-wrap">
                    <select id="filterSapi" class="kp-inline-select">
                        <option value="semua">Semua Sapi</option>
                        @foreach($sapis as $sapi)
                            <option value="{{ $sapi->id }}">{{ $sapi->name }}</option>
                        @endforeach
                    </select>
                    <svg class="kp-inline-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>

                {{-- Sesi dropdown --}}
                <div class="kp-inline-select-wrap">
                    <select id="filterSesi" class="kp-inline-select">
                        <option value="semua">Semua Sesi</option>
                        <option value="pagi">Pagi</option>
                        <option value="sore">Sore</option>
                    </select>
                    <svg class="kp-inline-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            {{-- RIGHT: Filter + Lihat Laporan --}}
            <div class="kp-riwayat-filters-right">
                <button type="button" class="kp-filter-btn" id="btnFilterApply">
                    <img src="{{ asset('images/icons/iconfilter.svg') }}" alt="" style="width:14px; height:14px; margin-right:6px;">
                    Filter
                </button>

                <a href="/owner/laporan" class="kp-btn-laporan">
                    <img src="{{ asset('images/icons/icondataputih.svg') }}" alt="" style="width:15px; height:15px; margin-right:6px; filter: brightness(0) invert(1);">
                    Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    {{-- Table content --}}
    <div class="kp-table-container">
        <table class="kp-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th style="padding-left: 46px;">Sesi</th>
                    <th style="padding-left: 56px;">Sapi</th>
                    <th>Jumlah Susu</th>
                    <th>Waktu Input</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="kp-tbody">
                @forelse($produksis as $prod)
                    <tr class="kp-row" data-sapi-id="{{ $prod->sapi_id }}" data-sesi="{{ $prod->sesi }}" data-tanggal="{{ $prod->tanggal }}" data-volume="{{ $prod->jumlah_susu }}">
                        <td>{{ \Carbon\Carbon::parse($prod->tanggal)->locale('id')->isoFormat('DD MMMM YYYY') }}</td>
                        <td>
                            <div class="kp-session-cell">
                                @if(strtolower($prod->sesi) === 'pagi')
                                    <img src="{{ asset('images/icons/iconmatahari.svg') }}" alt="Pagi" class="kp-session-icon">
                                    <span>Pagi</span>
                                @else
                                    <img src="{{ asset('images/icons/iconbulan.svg') }}" alt="Sore" class="kp-session-icon">
                                    <span>Sore</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="kp-sapi-cell">
                                <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="" class="kp-sapi-icon">
                                <div>
                                    <div class="kp-sapi-name">{{ $prod->sapi->name }}</div>
                                    <div class="kp-sapi-code">{{ $prod->sapi->code }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ floatval($prod->jumlah_susu) }} Liter</td>
                        <td>{{ \Carbon\Carbon::parse($prod->created_at)->format('H:i') }}</td>
                        <td>
                            <span class="kp-badge kp-badge--success">Tersimpan</span>
                        </td>
                        <td style="position: relative;">
                            <button type="button" class="kp-btn-action" title="Aksi" onclick="toggleDropdown(this, event)">
                                <img src="{{ asset('images/icons/iconedit.svg') }}" alt="Aksi" style="width:20px; height:20px;">
                            </button>
                            {{-- Dropdown actions --}}
                            <div class="kp-action-dropdown">
                                <button type="button" class="kp-dropdown-item" onclick="openEditModal({{ $prod->sapi_id }}, '{{ $prod->id }}', '{{ $prod->sesi }}', '{{ floatval($prod->jumlah_susu) }}', '{{ $prod->tanggal }}')">
                                    <img src="{{ asset('images/icons/iconpensiledit.svg') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
                                    Edit Produksi
                                </button>
                                <form action="{{ route('karyawan.produksi.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Hapus pencatatan produksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="kp-dropdown-item kp-dropdown-item--danger">
                                        <img src="{{ asset('images/icons/icontrashmerah.svg') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
                                        Hapus Produksi
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="kp-empty-row">
                        <td colspan="7">
                            <div class="kp-empty">
                                <h4 class="kp-empty__title">Tidak ada data produksi</h4>
                                <p class="kp-empty__sub">Data produksi susu saat ini kosong atau belum dimasukkan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="kp-pagination-bar" id="kp-pagination-bar">
        <span class="kp-pagination-info" id="kp-pagination-info">Menampilkan 0 - 0 dari 0 Data</span>
        <nav class="kp-pagination-nav" id="kp-pagination-nav" aria-label="Navigasi halaman"></nav>
    </div>
</div>

{{-- Modal Edit Produksi --}}
<div id="kpModal" class="kp-modal-overlay" style="display: none;">
    <div class="kp-modal-content">
        <div class="kp-modal-header">
            <h3 class="kp-modal-title">
                <img src="{{ asset('images/icons/iconpensil2.svg') }}" style="width:18px; height:18px; margin-right:8px; vertical-align:middle;">
                <span style="vertical-align:middle;">Edit Produksi Susu</span>
            </h3>
            <button type="button" class="kp-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form id="kpForm" action="" method="POST">
            @csrf
            @method('PUT')

            {{-- Tanggal --}}
            <div class="kp-modal-group">
                <label for="formTanggal">Tanggal</label>
                <div class="kp-modal-input-wrapper">
                    <div class="kp-modal-left-icon">
                        <img src="{{ asset('images/icons/icon kalender.svg') }}" alt="">
                    </div>
                    <input type="date" name="tanggal" id="formTanggal" class="kp-modal-input-no-chevron" required>
                </div>
            </div>

            {{-- Sesi toggle buttons --}}
            <div class="kp-modal-group">
                <label>Sesi</label>
                {{-- Hidden select to carry actual form value --}}
                <select name="sesi" id="formSesi" style="display:none;" required>
                    <option value="pagi">Pagi</option>
                    <option value="sore">Sore</option>
                </select>
                <div class="kp-sesi-toggle">
                    <button type="button" class="kp-sesi-btn kp-sesi-btn--active" id="sesiPagiBtn" onclick="selectSesi('pagi')">
                        <img src="{{ asset('images/icons/iconmatahari.svg') }}" alt="" class="kp-sesi-btn-icon">
                        Pagi
                        <span class="kp-sesi-radio"></span>
                    </button>
                    <button type="button" class="kp-sesi-btn" id="sesiSoreBtn" onclick="selectSesi('sore')">
                        <img src="{{ asset('images/icons/iconbulan.svg') }}" alt="" class="kp-sesi-btn-icon">
                        Sore
                        <span class="kp-sesi-radio"></span>
                    </button>
                </div>
            </div>

            {{-- Pilih Sapi --}}
            <div class="kp-modal-group">
                <label for="formSapi">Pilih Sapi</label>
                <div class="kp-modal-input-wrapper">
                    <div class="kp-modal-left-icon">
                        <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="" style="width:20px; height:20px;">
                    </div>
                    <select name="sapi_id" id="formSapi" required>
                        @foreach($sapis as $sapi)
                            <option value="{{ $sapi->id }}">{{ $sapi->name }} ({{ $sapi->code }})</option>
                        @endforeach
                    </select>
                    <svg class="kp-modal-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            {{-- Jumlah Susu --}}
            <div class="kp-modal-group">
                <label for="formJumlah">Jumlah Susu (Liter)</label>
                <div class="kp-modal-input-wrapper">
                    <input type="number" name="jumlah_susu" id="formJumlah" step="any" class="kp-modal-input-no-chevron" placeholder="Masukkan jumlah susu" style="padding-left:14px; padding-right:32px;" required>
                    <span class="kp-modal-suffix">L</span>
                </div>
            </div>

            <div class="kp-modal-actions">
                <button type="button" class="kp-modal-btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="kp-modal-btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>


@endsection

@push('scripts')
<script>
(function () {
    /* ── Config ───────────────────────────────────────────────── */
    const PER_PAGE = 4;

    /* ── State ────────────────────────────────────────────────── */
    let currentPage = 1;
    let allRows = Array.from(document.querySelectorAll('#kp-tbody tr.kp-row'));
    let filteredRows = [...allRows];

    /* ── DOM Elements ─────────────────────────────────────────── */
    const filterSapi = document.getElementById('filterSapi');
    const filterSesi = document.getElementById('filterSesi');
    const filterStart = document.getElementById('filterTanggalMulai');
    const filterEnd = document.getElementById('filterTanggalSelesai');
    const btnFilter = document.getElementById('btnFilterApply');
    const tbody = document.getElementById('kp-tbody');
    const emptyRow = document.getElementById('kp-empty-row');
    const paginationBar = document.getElementById('kp-pagination-bar');

    const initialTotalSapi = {{ $totalSapi }};
    const initialWeeklyProduction = {{ $weeklyProduction }};
    const initialMonthlyProduction = {{ $monthlyProduction }};
    const initialTodayProduction = {{ $todayProduction }};

    function updateKaryawanStats() {
        const valSapi = filterSapi.value;
        const valSesi = filterSesi.value;
        const valStart = filterStart.value;
        const valEnd = filterEnd.value;

        const isFiltered = (valSapi !== 'semua' || valSesi !== 'semua' || valStart || valEnd);

        if (!isFiltered) {
            document.getElementById('stat-total-sapi').textContent = initialTotalSapi.toLocaleString('id-ID');
            document.getElementById('label-sapi').textContent = "Semua Sapi";

            document.getElementById('stat-weekly-production').innerHTML = `${initialWeeklyProduction.toLocaleString('id-ID')}<span class="kp-stat-card__value-unit">L</span>`;
            document.getElementById('label-weekly').textContent = "Total Minggu Ini";

            document.getElementById('stat-monthly-production').innerHTML = `${initialMonthlyProduction.toLocaleString('id-ID')}<span class="kp-stat-card__value-unit">L</span>`;
            document.getElementById('label-monthly').textContent = "Total Bulan Ini";

            document.getElementById('stat-today-production').innerHTML = `${initialTodayProduction.toLocaleString('id-ID')}<span class="kp-stat-card__value-unit">L</span>`;
            document.getElementById('label-today').textContent = "Total Hari Ini";
        } else {
            const uniqueSapi = new Set();
            let totalVolume = 0;
            let countRecords = filteredRows.length;

            filteredRows.forEach(row => {
                const sId = row.getAttribute('data-sapi-id');
                const vol = parseFloat(row.getAttribute('data-volume')) || 0;
                if (sId) uniqueSapi.add(sId);
                totalVolume += vol;
            });

            const avgVolume = countRecords > 0 ? (totalVolume / countRecords).toFixed(1) : '0';

            document.getElementById('stat-total-sapi').textContent = uniqueSapi.size.toLocaleString('id-ID');
            document.getElementById('label-sapi').textContent = "Sapi Terfilter";

            document.getElementById('stat-weekly-production').innerHTML = `${parseFloat(avgVolume).toLocaleString('id-ID')}<span class="kp-stat-card__value-unit">L</span>`;
            document.getElementById('label-weekly').textContent = "Rata-rata Terfilter";

            document.getElementById('stat-monthly-production').textContent = countRecords.toLocaleString('id-ID');
            document.getElementById('label-monthly').textContent = "Banyak Transaksi";

            document.getElementById('stat-today-production').innerHTML = `${totalVolume.toLocaleString('id-ID')}<span class="kp-stat-card__value-unit">L</span>`;
            document.getElementById('label-today').textContent = "Total Volume Terfilter";
        }
    }

    function filterData() {
        const valSapi = filterSapi.value;
        const valSesi = filterSesi.value;
        const valStart = filterStart.value;
        const valEnd = filterEnd.value;

        filteredRows = allRows.filter(row => {
            // Sapi filter
            if (valSapi !== 'semua' && row.getAttribute('data-sapi-id') !== valSapi) {
                return false;
            }
            // Sesi filter
            if (valSesi !== 'semua' && row.getAttribute('data-sesi') !== valSesi) {
                return false;
            }
            // Date filter
            const rowDate = row.getAttribute('data-tanggal');
            if (valStart && rowDate < valStart) {
                return false;
            }
            if (valEnd && rowDate > valEnd) {
                return false;
            }
            return true;
        });

        currentPage = 1;
        render();
        updateKaryawanStats();
    }

    function render() {
        const total = filteredRows.length;
        const totalPages = Math.ceil(total / PER_PAGE);

        // Hide all rows first
        allRows.forEach(row => row.style.display = 'none');

        if (total === 0) {
            if (emptyRow) emptyRow.style.display = '';
            paginationBar.style.display = 'none';
            return;
        }

        if (emptyRow) emptyRow.style.display = 'none';
        paginationBar.style.display = '';

        const startIdx = (currentPage - 1) * PER_PAGE;
        const endIdx = Math.min(startIdx + PER_PAGE, total);

        // Show row slice
        for (let i = startIdx; i < endIdx; i++) {
            filteredRows[i].style.display = '';
        }

        // Info text
        const infoEl = document.getElementById('kp-pagination-info');
        infoEl.textContent = `Menampilkan ${total === 0 ? 0 : startIdx + 1} - ${endIdx} dari ${total} Data`;

        // Render Pagination buttons
        const navEl = document.getElementById('kp-pagination-nav');
        navEl.innerHTML = '';

        function btn(label, page, cls, disabled) {
            const b = document.createElement('button');
            b.className = 'kp-page-btn ' + (cls || '');
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
        btn('\u2039', currentPage - 1, 'kp-page-btn--arrow', currentPage === 1);

        // Page buttons with ellipsis
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
                const e = document.createElement('button');
                e.className = 'kp-page-btn kp-page-btn--ellipsis';
                e.textContent = '...';
                e.disabled = true;
                navEl.appendChild(e);
            }
            btn(p, p, p === currentPage ? 'kp-page-btn--active' : '', false);
            prev = p;
        });

        // Next arrow
        btn('\u203A', currentPage + 1, 'kp-page-btn--arrow', currentPage === totalPages || total === 0);
    }

    // Attach filter event
    btnFilter.addEventListener('click', filterData);

    /* ── Dropdown and Modal Handling ──────────────────────────── */
    function toggleDropdown(btn, event) {
        event.stopPropagation();
        const dropdown = btn.nextElementSibling;
        const isCurrentlyOpen = dropdown.style.display === 'block';

        // Close all other dropdowns
        document.querySelectorAll('.kp-action-dropdown').forEach(el => {
            el.style.display = 'none';
            el.classList.remove('kp-action-dropdown--up');
        });

        if (!isCurrentlyOpen) {
            dropdown.style.display = 'block';
            // Check if dropdown would overflow bottom of viewport
            const rect = dropdown.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            if (rect.bottom > viewportHeight - 10) {
                dropdown.classList.add('kp-action-dropdown--up');
            }
        }
    }

    function openEditModal(sapiId, id, sesi, volume, tanggal) {
        const modal = document.getElementById('kpModal');
        const form = document.getElementById('kpForm');

        // Close dropdowns
        document.querySelectorAll('.kp-action-dropdown').forEach(el => {
            el.style.display = 'none';
            el.classList.remove('kp-action-dropdown--up');
        });

        // Setup Form
        form.action = `/karyawan/produksi/${id}`;
        document.getElementById('formSapi').value = sapiId;
        updateSearchableSelect('formSapi');
        document.getElementById('formTanggal').value = tanggal;
        document.getElementById('formJumlah').value = volume;

        // Set Sesi toggle
        if (window.selectSesi) window.selectSesi(sesi);

        // Open
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('kpModal').style.display = 'none';
    }

    // Global click listener to close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.kp-btn-action') && !e.target.closest('.kp-action-dropdown')) {
            document.querySelectorAll('.kp-action-dropdown').forEach(el => el.style.display = 'none');
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

    // Expose functions globally for inline onclick attributes
    window.toggleDropdown = toggleDropdown;
    window.openEditModal = openEditModal;
    window.closeModal = closeModal;
    window.selectSesi = function(val) {
        const hiddenSel = document.getElementById('formSesi');
        const pagiBtn  = document.getElementById('sesiPagiBtn');
        const soreBtn  = document.getElementById('sesiSoreBtn');
        if (!hiddenSel || !pagiBtn || !soreBtn) return;
        hiddenSel.value = val;
        if (val === 'pagi') {
            pagiBtn.classList.add('kp-sesi-btn--active');
            soreBtn.classList.remove('kp-sesi-btn--active');
        } else {
            soreBtn.classList.add('kp-sesi-btn--active');
            pagiBtn.classList.remove('kp-sesi-btn--active');
        }
    };

    // Initialize searchable dropdowns
    initSearchableDropdown('inputSapi', 'Cari Sapi...');
    initSearchableDropdown('formSapi', 'Cari Sapi...');

    // Initial render
    render();

    // Sync Title
    document.title = "Produksi Susu | Parman Farm";
    // Sesi icon: sun for Pagi, moon for Sore
    (function() {
        const sesiSelect = document.getElementById('inputSesi');
        const sesiIcon = document.getElementById('sesiIcon');
        if (!sesiSelect || !sesiIcon) return;

        const iconMatahari = "{{ asset('images/icons/iconmatahari.svg') }}";
        const iconBulan = "{{ asset('images/icons/iconbulan.svg') }}";

        function updateSesiIcon() {
            if (sesiSelect.value === 'pagi') {
                sesiIcon.src = iconMatahari;
            } else {
                sesiIcon.src = iconBulan;
            }
        }

        sesiSelect.addEventListener('change', updateSesiIcon);
        updateSesiIcon(); // set on page load
    })();

    // Expose selectSesi to update input display icon as well
    const inputSesi = document.getElementById('inputSesi');
    if (inputSesi) {
        inputSesi.addEventListener('change', function() {
            const sesiIcon = document.getElementById('sesiIcon');
            const iconMatahari = "{{ asset('images/icons/iconmatahari.svg') }}";
            const iconBulan = "{{ asset('images/icons/iconbulan.svg') }}";
            if (this.value === 'pagi') {
                sesiIcon.src = iconMatahari;
            } else {
                sesiIcon.src = iconBulan;
            }
        });
    }

})();
</script>
@endpush
